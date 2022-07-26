<?php
require_once("../../conexion.php");
require '../../../assets/plugins/spreadSheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$trabajador = @$_GET["trabajador"];
$fInicio = @$_GET["fInicio"];
$fFinal = @$_GET["fFinal"];
$estado = @$_GET["estado"];
$idOrden = 1;
$whereOrden = "";

$resComensales = "SELECT COME_id, COME_nombres, AREA_descripcion, COME_dni FROM comensales co 
                  INNER JOIN areas ar ON co.AREA_id01=ar.AREA_id WHERE COME_estado=1";
# AND COME_id=199
$resComesal = mysqli_query($conexion, $resComensales);
$auxiliar = null;
$arrayDiasRegistroComensales = [];
$arrayDiasGeneralComensales = [];
$resTipoAlimento = mysqli_query($conexion, "SELECT * FROM tipo_alimentos WHERE TIAL_principal=1 AND TIAL_estado =1");
foreach ($resComesal as $x) {
  $arrayDiasSalidaPorComensal = [];
  $contadorAlimentos = 0;
  foreach ($resTipoAlimento as $k) {
    $conSalidas = "SELECT DATE(REAL_fecha) as fechaRegistro, REAL_id,CEDE_descripcion FROM registros_alimentacion ra
                   INNER JOIN cedes ce ON ra.CEDE_id01=ce.CEDE_id
                   WHERE COME_id01=" . $x["COME_id"] . " AND TIAL_id01=" . $k["TIAL_id"] . " AND REAL_estado=1";
    $resSalidas = mysqli_query($conexion, $conSalidas);
    if (mysqli_num_rows($resSalidas) > 0) {
      $arrayDiasSalidaPorComensal[$contadorAlimentos] =  [];
      //var_dump($arrayDiasSalidaPorComensal);
      //var_dump($arrayDiasSalidaPorComensal[$contadorAlimentos][$k['TIAL_descripcion']]);
      foreach ($resSalidas as $t) {
        $cedeSalida = $t['CEDE_descripcion'];
        array_push($arrayDiasSalidaPorComensal[$contadorAlimentos],  $t['fechaRegistro']);
      }
    } else {
      array_push($arrayDiasSalidaPorComensal, []);
    }

    $contadorAlimentos++;
  }
/*     echo "<pre>";
  var_dump($arrayDiasSalidaPorComensal);
  echo "<pre>"; */
  #var_dump($arrayDiasSalidaPorComensal);
  $sumaDesayuno = count($arrayDiasSalidaPorComensal[0]);
  $sumaAlmuerzo = count($arrayDiasSalidaPorComensal[1]);
  $sumaCena = count($arrayDiasSalidaPorComensal[2]);

  $existenRegistrosComensal =  $sumaDesayuno + $sumaAlmuerzo + $sumaCena;
  if ($existenRegistrosComensal > 0) {
    array_push($arrayDiasRegistroComensales, [
      'nombres' => $x['COME_nombres'],
      'dni' => $x['COME_dni'],
      'cargo' => $x['AREA_descripcion'],
      'cede' => $cedeSalida,
      'diasRegistro' => $arrayDiasSalidaPorComensal,
    ]);
  }
}
# echo "<pre>"; var_dump($arrayDiasRegistroComensales); echo "<pre>";

/* --------------------------------- */

$diasEspanol = array(
  'Monday' => 'Lunes',
  'Tuesday' => 'Martes',
  'Wednesday' => 'Miércoles',
  'Thursday' => 'Jueves',
  'Friday' => 'Viernes',
  'Saturday' => 'Sábado',
  'Sunday' => 'Domingo'
);
function createDateRangeArray($strDateFrom, $strDateTo, $diasEspanol)
{
  // takes two dates formatted as YYYY-MM-DD and creates an
  // inclusive array of the dates between the from and to dates.

  // could test validity of dates here but I'm already doing
  $aryRange = [];

  $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
  $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

  if ($iDateTo >= $iDateFrom) {
    $nameDay = $diasEspanol[date('l', strtotime(date('Y-m-d', $iDateFrom)))];
    array_push($aryRange, ['nombre' => $nameDay, 'fecha' => date('Y-m-d', $iDateFrom)]);
    while ($iDateFrom < $iDateTo) {
      $iDateFrom += 86400; // add 24 hours
      $nameDay = $diasEspanol[date('l', strtotime(date('Y-m-d', $iDateFrom)))];
      array_push($aryRange, ['nombre' => $nameDay, 'fecha' => date('Y-m-d', $iDateFrom)]);
    }
  }
  return $aryRange;
}
$arrayDiasGeneralComensales = [];
$arrayDiasAuxiliar = [];
$arrayDiasSelecionados = createDateRangeArray('2022-07-15', '2022-07-31', $diasEspanol);
$contadorComensales2=0;
foreach ($arrayDiasRegistroComensales as $x) {
  $contadorDiasSeleccionados=0;
  array_push($arrayDiasGeneralComensales, [
    'nombres' => $x['nombres'],
    'dni' => $x['dni'],
    'cargo' => $x['cargo'],
    'cede' => $cedeSalida,
    'diasRegistro' => [],
  ]);
  foreach ($arrayDiasSelecionados as $y) {
    $contador = 0;  
    foreach ($x['diasRegistro'] as $i) {
/* echo "<pre>"; var_dump($i); echo "<pre>"; */
      $arrayDiasAuxiliar[$contador] =  null;
      if (array_search($y['fecha'], $i) !== false) {
        $arrayDiasAuxiliar[$contador]= 1;
      } else {
        #array_push($arrayDiasAuxiliar[$contador], 0);
        $arrayDiasAuxiliar[$contador]= 0;
      }
      $contador++;
    }
    array_push($arrayDiasGeneralComensales[$contadorComensales2]['diasRegistro'],$arrayDiasAuxiliar);
    $contadorDiasSeleccionados++;
  }
  $contadorComensales2++;
}

/* $whereTrabajador = ($trabajador == NULL) ? "" : "WHERE PER_dni=$trabajador";
($estado == NULL)
    ? $whereOrden = "AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'"
    : $whereOrden = "AND ORD_estado='$estado' AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'";

$resConsultaPersonas = mysqli_query($conexion, "SELECT * FROM  personas $whereTrabajador"); */
$spreadsheet = new Spreadsheet();

$letras = "a-b-c-d-e-f-g-h-i-j-k-l-m-n-o-p-q-r-s-t-u-v-w-x-y-z";
$array_letras = explode("-", $letras);
for ($i = 0; $i < count($array_letras); $i++) {
    $spreadsheet->getActiveSheet()->getColumnDimension($array_letras[$i])->setAutoSize(true);
}
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$spreadsheet->getActiveSheet()->mergeCells('H2:J2');
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('H2', 'REPORTE MOVIMIENTOS');
$sheet->setCellValue('A4', 'FECHA INICIO');
$sheet->setCellValue('A5', 'FECHA FINAL');
$sheet->setCellValue('B4', $fInicio);
$sheet->setCellValue('B5', $fFinal);
$sheet->setCellValue('A6', 'TRABAJADOR');
$sheet->setCellValue('B6', '');
$filaAfectadaColor = "A8:L8";
$spreadsheet->getActiveSheet()->getStyle($filaAfectadaColor)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('D4D3D3');


$sheet->setCellValue('A8', '# OP');
$sheet->setCellValue('B8', 'Persona');
$sheet->setCellValue('C8', 'Orden Motivo');
$sheet->setCellValue('D8', 'C. de Costo');
$sheet->setCellValue('E8', 'Moneda');
$sheet->setCellValue('F8', 'T. Depositado');
$sheet->setCellValue('G8', 'Fecha de OP');
$sheet->setCellValue('H8', 'Aprobacion');
$sheet->setCellValue('I8', 'Fecha Aprobacion');
$sheet->setCellValue('J8', 'Codigo Transaccion');
$sheet->setCellValue('K8', 'Fecha Transaccion');
$sheet->setCellValue('L8', 'Estado');

/* $resConDetalleOrden = mysqli_query($conexion, "SELECT *,DATE(ORD_fecha_creacion) as fecha, SUM(DEOR_monto) as sumaDebes, sum(if(ORD_tipomoneda = 'SOLES',DEOR_monto,0)) as sumaSoles,sum(if(ORD_tipomoneda = 'DOLARES',DEOR_monto,0)) as sumaDolares FROM detalleorden do INNER JOIN ordenes o ON do.ORD_id01 = o.ORD_id INNER JOIN centros_costo cc ON cc.CECO_id=o.CECO_id01 INNER JOIN personas p ON p.PER_id=o.PER_id01 $whereTrabajador AND DEOR_operacion='DEBE' $whereOrden GROUP BY ORD_id"); */
$sumaTotal = 0;
$sumaSoles= 0;
$sumaDolares =0;
$contadorRegistrosPorOrden = 9;
$contadorLetras = 0;
//$cell = $sheet->getCellByColumnAndRow(9 + 1,11);
//$column=10;
$rowNombres=9;
$rowFecha=10;
for ($column = 1; $column < count($arrayDiasSelecionados); $column++) {
  $sheet->setCellValueByColumnAndRow($column, $rowNombres, $arrayDiasSelecionados[$column]['nombre']);
  $sheet->setCellValueByColumnAndRow($column, $rowFecha, $arrayDiasSelecionados[$column]['fecha']);
}
/* foreach ($arrayDiasSelecionados as $f) {

    $sheet->setCellValue($array_letras[$contadorLetras] . $contadorRegistrosPorOrden, ;
    $contadorRegistrosPorOrden++;
    $contadorLetras++;
} */
/* $sheet->setCellValue('E' . $contadorRegistrosPorOrden, 'S. SOLES');
$sheet->setCellValue('E' . ($contadorRegistrosPorOrden+1), 'S. DOLARES');
$sheet->setCellValue('E' . ($contadorRegistrosPorOrden+2), 'S. TOTAL');
$sheet->setCellValue('F' . $contadorRegistrosPorOrden, $sumaSoles);
$sheet->setCellValue('F' . ($contadorRegistrosPorOrden+1), $sumaDolares);
$sheet->setCellValue('F' . ($contadorRegistrosPorOrden+2), $sumaTotal); */
$conexion->close();
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte orden.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
