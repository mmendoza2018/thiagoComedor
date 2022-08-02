<?php
require_once("../../conexion.php");
require '../../../assets/plugins/spreadSheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$idComensal = @$_GET["id"];
$fInicio = @$_GET["fInicio"];
$fFinal = @$_GET["fFinal"];
//$estado = @$_GET["estado"];
$idOrden = 1;
$whereComensal = ($idComensal != "") ? "AND COME_id=$idComensal" : "";
$whereFechas = ($fInicio != "" && $fFinal !="") 
                ? "AND (REAL_fecha BETWEEN '$fInicio' AND '$fFinal')" 
                : "";

$resComensales = "SELECT COME_id, COME_nombres, AREA_descripcion, COME_dni FROM comensales co 
                  INNER JOIN areas ar ON co.AREA_id01=ar.AREA_id WHERE COME_estado=1 $whereComensal";
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
    $conSalidas = "SELECT DATE(REAL_fecha) as fechaRegistro, REAL_id,CEDE_descripcion,REAL_precio_comida FROM registros_alimentacion ra
                   INNER JOIN cedes ce ON ra.CEDE_id01=ce.CEDE_id
                   WHERE COME_id01=" . $x["COME_id"] . " AND TIAL_id01=" . $k["TIAL_id"] . " AND REAL_estado=1 $whereFechas";
    $resSalidas = mysqli_query($conexion, $conSalidas);
    if (mysqli_num_rows($resSalidas) > 0) {
      $arrayDiasSalidaPorComensal[$contadorAlimentos] =  ["fecha" => [], "precio"=> []];
      //var_dump($arrayDiasSalidaPorComensal);
      //var_dump($arrayDiasSalidaPorComensal[$contadorAlimentos][$k['TIAL_descripcion']]);
      foreach ($resSalidas as $t) {
        $cedeSalida = $t['CEDE_descripcion'];
        array_push($arrayDiasSalidaPorComensal[$contadorAlimentos]["fecha"],$t['fechaRegistro']);
        array_push($arrayDiasSalidaPorComensal[$contadorAlimentos]["precio"],floatval($t['REAL_precio_comida']));

      }
    } else {
      array_push($arrayDiasSalidaPorComensal, ["fecha" => [], "precio"=> []]);
    }
    $contadorAlimentos++;
  }
  #var_dump($arrayDiasSalidaPorComensal);
  $sumaDesayuno = count($arrayDiasSalidaPorComensal[0]["fecha"]);
  $sumaAlmuerzo = count($arrayDiasSalidaPorComensal[1]["fecha"]);
  $sumaCena = count($arrayDiasSalidaPorComensal[2]["fecha"]);

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
/*  echo "<pre>"; var_dump($arrayDiasRegistroComensales); echo "<pre>";
die(); */
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
$arrayDiasSelecionados = createDateRangeArray($fInicio, $fFinal, $diasEspanol);
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
//echo "<pre>"; var_dump($i); echo "<pre>";
      $arrayDiasAuxiliar[$contador] =  null;
      if (array_search($y['fecha'], $i["fecha"]) !== false) {
        $arrayDiasAuxiliar[$contador]= 1;
      } else {
        $arrayDiasAuxiliar[$contador]= 0;
      }
      $contador++;
    }
    array_push($arrayDiasGeneralComensales[$contadorComensales2]['diasRegistro'],$arrayDiasAuxiliar);
    $contadorDiasSeleccionados++;
  }
  $contadorComensales2++;
}
//echo "<pre>"; var_dump($arrayDiasGeneralComensales); echo "<pre>";

/* $whereTrabajador = ($trabajador == NULL) ? "" : "WHERE PER_dni=$trabajador";
($estado == NULL)
    ? $whereOrden = "AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'"
    : $whereOrden = "AND ORD_estado='$estado' AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'";

$resConsultaPersonas = mysqli_query($conexion, "SELECT * FROM  personas $whereTrabajador"); */
$spreadsheet = new Spreadsheet();

$abecedario=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
'FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ','FK','FL','FM','FN','FO','FP','FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ',
'GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ','GK','GL','GM','GN','GO','GP','GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ',
'HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ','HK','HL','HM','HN','HO','HP','HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ',
'IA','IB','IC','ID','IE','IF','IG','IH','II','IJ','IK','IL','IM','IN','IO','IP','IQ','IR','IS','IT','IU','IV','IW','IX','IY','IZ',
'JA','JB','JC','JD','JE','JF','JG','JH','JI','JJ','JK','JL','JM','JN','JO','JP','JQ','JR','JS','JT','JU','JV','JW','JX','JY','JZ',
'KA','KB','KC','KD','KE','KF','KG','KH','KI','KJ','KK','KL','KM','KN','KO','KP','KQ','KR','KS','KT','KU','KV','KW','KX','KY','KZ',
'LA','LB','LC','LD','LE','LF','LG','LH','LI','LJ','LK','LL','LM','LN','LO','LP','LQ','LR','LS','LT','LU','LV','LW','LX','LY','LZ',
'MA','MB','MC','MD','ME','MF','MG','MH','MI','MJ','MK','ML','MM','MN','MO','MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ'];
for ($i = 0; $i < 6; $i++) {
    $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$i])->setAutoSize(true);
}
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$spreadsheet->getActiveSheet()->mergeCells('H2:R2');
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('H2', 'REPORTE MOVIMIENTOS'.$fFinal);
$sheet->setCellValue('B7', '#');
$sheet->setCellValue('C7', 'Comedor');
$sheet->setCellValue('D7', 'Dni');
$sheet->setCellValue('E7', 'Nombres');
$sheet->setCellValue('F7', 'Cargo');

$filaAfectadaColorDet = 'B7:F7';
$spreadsheet->getActiveSheet()->getStyle($filaAfectadaColorDet)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('D4D3D3');

$sumaTotal = 0;
$sumaSoles= 0;
$sumaDolares =0;
$contadorRegistrosPorOrden = 9;
$contadorLetras = 0;
//$cell = $sheet->getCellByColumnAndRow(9 + 1,11);
//$column=10;
$rowNombres=5;
$rowFecha=6;
#$row=10;
$ultimaColumnData=0;

$rowData=8;
for ($contadorTrajadores = 0; $contadorTrajadores < count($arrayDiasGeneralComensales); $contadorTrajadores++) {
  $columnData = 7;
  $sheet->setCellValueByColumnAndRow(2, $rowData, $contadorTrajadores+1);
  $sheet->setCellValueByColumnAndRow(3, $rowData, $arrayDiasGeneralComensales[$contadorTrajadores]['cede']);
  $sheet->setCellValueByColumnAndRow(4, $rowData, $arrayDiasGeneralComensales[$contadorTrajadores]['nombres']);
  $sheet->setCellValueByColumnAndRow(5, $rowData, $arrayDiasGeneralComensales[$contadorTrajadores]['dni']);
  $sheet->setCellValueByColumnAndRow(6, $rowData, $arrayDiasGeneralComensales[$contadorTrajadores]['cargo']);

  foreach ($arrayDiasGeneralComensales[$contadorTrajadores]['diasRegistro'] as $diaRegistros) {
    foreach ($diaRegistros as $tipos) {
      $sheet->setCellValueByColumnAndRow(
        $columnData,
        $rowData, 
        $tipos);
        $columnData++;
    }
  }
  $ultimaColumnData = $columnData;
  $rowData++;
}

$contAlfabeto = 8;
$column = 6;
$ultimaColumnaAfectada = '';
$posicionUltimaColumnaAfectada = 0;
for ($cont = 0; $cont < count($arrayDiasSelecionados); $cont++) {
  $columnAux=$column;
  //creamos los nombres d'dias  coslpan 3
  $spreadsheet->getActiveSheet()->mergeCells($abecedario[$column].'5'.':'. $abecedario[$columnAux+2].'5');
  //creamos las fechas con coslpan 3
  $spreadsheet->getActiveSheet()->mergeCells($abecedario[$column].'6'.':'. $abecedario[$columnAux+2].'6');
  $ultimaColumnaAfectada = $abecedario[$columnAux+2].'6';
  $posicionUltimaColumnaAfectada = $columnAux+2;
  //insertamos las nombres 
  $sheet->setCellValue($abecedario[$column].'5', $arrayDiasSelecionados[$cont]['nombre']);
  //insertamos las fechas 
  $sheet->setCellValue($abecedario[$column].'6', $arrayDiasSelecionados[$cont]['fecha']);
  //insertamos D,A,C
  $sheet->setCellValue($abecedario[$column].'7', 'D');
  $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$column])->setWidth(4);
  $sheet->setCellValue($abecedario[$column+1].'7', 'A');
  $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$column+1])->setWidth(4);
  $sheet->setCellValue($abecedario[$column+2].'7', 'C');
  $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$column+2])->setWidth(4);
  $column+=3;
}
$filaAfectadaColor = 'G5:'. $ultimaColumnaAfectada;
$spreadsheet->getActiveSheet()->getStyle($filaAfectadaColor)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('D4D3D3');


$posicionSiguienteColumnaAfectada = $posicionUltimaColumnaAfectada+1;
$arrayDescripcionTabla =['Conteo de Atenciones','Valorización'];
$ultimaColumnaFinal = '';
for ($i=0; $i <3; $i++) { 

  $columnAux2=$posicionSiguienteColumnaAfectada;
  if ($i==2) {
    $sheet->setCellValue($abecedario[$posicionSiguienteColumnaAfectada].'6', 'TOTAL');
    $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$posicionSiguienteColumnaAfectada])->setWidth(20);
    $ultimaColumnaFinal = $abecedario[$posicionSiguienteColumnaAfectada].'6';
    break;
  }
  //creamos los nombres d'dias  coslpan 3
  $spreadsheet->getActiveSheet()
  ->mergeCells($abecedario[$posicionSiguienteColumnaAfectada].'6'.':'. $abecedario[$columnAux2+2].'6');

  $sheet->setCellValue($abecedario[$posicionSiguienteColumnaAfectada].'6', $arrayDescripcionTabla[$i]);
  //insertamos D,A,C
  $sheet->setCellValue($abecedario[$posicionSiguienteColumnaAfectada].'7', 'D');
  $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$posicionSiguienteColumnaAfectada])->setWidth(10);
  $sheet->setCellValue($abecedario[$posicionSiguienteColumnaAfectada+1].'7', 'A');
  $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$posicionSiguienteColumnaAfectada+1])->setWidth(10);
  $sheet->setCellValue($abecedario[$posicionSiguienteColumnaAfectada+2].'7', 'C');
  $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$posicionSiguienteColumnaAfectada+2])->setWidth(10);

  $posicionSiguienteColumnaAfectada+=3;
}
 $filaAfectadaColorFinal = $ultimaColumnaAfectada . ':' .  $ultimaColumnaFinal;
$spreadsheet->getActiveSheet()->getStyle($filaAfectadaColorFinal)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('D4D3D3');

$sumaTotalGeneral = 0;
$ultimaColumnaTablaFinal=0;
$rowData2 =8;
$ultimaFilaTablaFinal=0;
if (count($arrayDiasRegistroComensales)>0) {
for ($contadorTrajadores = 0; $contadorTrajadores < count($arrayDiasRegistroComensales); $contadorTrajadores++) {
  $columnData2 = $ultimaColumnData;
  $sumaTotalMes = 0;
  foreach ($arrayDiasRegistroComensales[$contadorTrajadores]['diasRegistro'] as $tipos) {
    $diasEnElMes = count($tipos["fecha"]);
    $sumaTotalParcial = array_sum($tipos["precio"]);
    $sumaTotalMes += array_sum($tipos["precio"]);
    $sheet->setCellValueByColumnAndRow(
      $columnData2,
      $rowData2, 
      $diasEnElMes);
      $sheet->setCellValueByColumnAndRow(
        $columnData2+3,
        $rowData2, 
        $sumaTotalParcial);
        $columnData2++;
    }
    $sheet->setCellValueByColumnAndRow(
      $columnData2+3,
      $rowData2, 
      $sumaTotalMes);

      $sumaTotalGeneral += $sumaTotalMes;
      $ultimaColumnaTablaFinal = $columnData2+3;
      $ultimaFilaTablaFinal = $rowData2;
  $rowData2++;
}
$totalConIgv =  $sumaTotalGeneral*(18/100);

$sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal-1, $ultimaFilaTablaFinal+2, 'Sub. Total');
$sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal-1, $ultimaFilaTablaFinal+3, '18.0% IGV');
$sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal-1, $ultimaFilaTablaFinal+4, 'Total');

$sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal, $ultimaFilaTablaFinal+2, $sumaTotalGeneral);
$sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal, $ultimaFilaTablaFinal+3, $totalConIgv);
$sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal, $ultimaFilaTablaFinal+4, $sumaTotalGeneral+$totalConIgv);
}
$conexion->close();
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte orden.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
