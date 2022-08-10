<?php
require_once("../../conexion.php");
require '../../../assets/plugins/spreadSheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$idComensal = @$_GET["id"];
$fInicio = @$_GET["fInicio"];
$fFinal = @$_GET["fFinal"];
$tipoNormal = @$_GET["tipoNormal"];
$tipoAdicional = @$_GET["tipoAdicional"];
$idEmpresa = @$_GET["idEmpresa"];
$whereComensal = ($idComensal != "") ? "AND COME_id=$idComensal" : "";
$whereEmpresa = ($idEmpresa != "") ? "AND EMPR_id01=$idEmpresa" : "";
  $whereFechas = ($fInicio != "" && $fFinal != "")
    //? "AND (REAL_fecha BETWEEN '$fInicio' AND '$fFinal')"
    ? "AND (REAL_fecha >= '$fInicio' AND REAL_fecha <= '$fFinal')"
    : "";

//$estado = @$_GET["estado"];
$idOrden = 1;
$abecedario = [
  'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
  'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
  'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ',
  'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ',
  'DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ',
  'EA', 'EB', 'EC', 'ED', 'EE', 'EF', 'EG', 'EH', 'EI', 'EJ', 'EK', 'EL', 'EM', 'EN', 'EO', 'EP', 'EQ', 'ER', 'ES', 'ET', 'EU', 'EV', 'EW', 'EX', 'EY', 'EZ',
  'FA', 'FB', 'FC', 'FD', 'FE', 'FF', 'FG', 'FH', 'FI', 'FJ', 'FK', 'FL', 'FM', 'FN', 'FO', 'FP', 'FQ', 'FR', 'FS', 'FT', 'FU', 'FV', 'FW', 'FX', 'FY', 'FZ',
  'GA', 'GB', 'GC', 'GD', 'GE', 'GF', 'GG', 'GH', 'GI', 'GJ', 'GK', 'GL', 'GM', 'GN', 'GO', 'GP', 'GQ', 'GR', 'GS', 'GT', 'GU', 'GV', 'GW', 'GX', 'GY', 'GZ',
  'HA', 'HB', 'HC', 'HD', 'HE', 'HF', 'HG', 'HH', 'HI', 'HJ', 'HK', 'HL', 'HM', 'HN', 'HO', 'HP', 'HQ', 'HR', 'HS', 'HT', 'HU', 'HV', 'HW', 'HX', 'HY', 'HZ',
  'IA', 'IB', 'IC', 'ID', 'IE', 'IF', 'IG', 'IH', 'II', 'IJ', 'IK', 'IL', 'IM', 'IN', 'IO', 'IP', 'IQ', 'IR', 'IS', 'IT', 'IU', 'IV', 'IW', 'IX', 'IY', 'IZ',
  'JA', 'JB', 'JC', 'JD', 'JE', 'JF', 'JG', 'JH', 'JI', 'JJ', 'JK', 'JL', 'JM', 'JN', 'JO', 'JP', 'JQ', 'JR', 'JS', 'JT', 'JU', 'JV', 'JW', 'JX', 'JY', 'JZ',
  'KA', 'KB', 'KC', 'KD', 'KE', 'KF', 'KG', 'KH', 'KI', 'KJ', 'KK', 'KL', 'KM', 'KN', 'KO', 'KP', 'KQ', 'KR', 'KS', 'KT', 'KU', 'KV', 'KW', 'KX', 'KY', 'KZ',
  'LA', 'LB', 'LC', 'LD', 'LE', 'LF', 'LG', 'LH', 'LI', 'LJ', 'LK', 'LL', 'LM', 'LN', 'LO', 'LP', 'LQ', 'LR', 'LS', 'LT', 'LU', 'LV', 'LW', 'LX', 'LY', 'LZ',
  'MA', 'MB', 'MC', 'MD', 'ME', 'MF', 'MG', 'MH', 'MI', 'MJ', 'MK', 'ML', 'MM', 'MN', 'MO', 'MP', 'MQ', 'MR', 'MS', 'MT', 'MU', 'MV', 'MW', 'MX', 'MY', 'MZ'
];
//creamos el excel
$spreadsheet = new Spreadsheet();
if ($tipoNormal == "true") {
  
  $resComensales = "SELECT COME_id, COME_nombres, AREA_descripcion, COME_dni,EMPR_razonSocial FROM comensales co 
                  INNER JOIN areas ar ON co.AREA_id01=ar.AREA_id 
                  INNER JOIN empresas em ON co.EMPR_id01=em.EMPR_id 
                  WHERE COME_estado=1 $whereComensal $whereEmpresa";
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
        $arrayDiasSalidaPorComensal[$contadorAlimentos] =  ["fecha" => [], "precio" => []];
        //var_dump($arrayDiasSalidaPorComensal);
        //var_dump($arrayDiasSalidaPorComensal[$contadorAlimentos][$k['TIAL_descripcion']]);
        foreach ($resSalidas as $t) {
          $cedeSalida = $t['CEDE_descripcion'];
          array_push($arrayDiasSalidaPorComensal[$contadorAlimentos]["fecha"], $t['fechaRegistro']);
          array_push($arrayDiasSalidaPorComensal[$contadorAlimentos]["precio"], floatval($t['REAL_precio_comida']));
        }
      } else {
        array_push($arrayDiasSalidaPorComensal, ["fecha" => [], "precio" => []]);
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
        'empresa' => $x['EMPR_razonSocial'],
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
  $contadorComensales2 = 0;
  foreach ($arrayDiasRegistroComensales as $x) {
    $contadorDiasSeleccionados = 0;
    array_push($arrayDiasGeneralComensales, [
      'nombres' => $x['nombres'],
      'dni' => $x['dni'],
      'cargo' => $x['cargo'],
      'cede' => $cedeSalida,
      'empresa' => $x['empresa'],
      'diasRegistro' => [],
    ]);
    foreach ($arrayDiasSelecionados as $y) {
      $contador = 0;
      foreach ($x['diasRegistro'] as $i) {
        //echo "<pre>"; var_dump($i); echo "<pre>";
        $arrayDiasAuxiliar[$contador] =  null;
        if (array_search($y['fecha'], $i["fecha"]) !== false) {
          $arrayDiasAuxiliar[$contador] = 1;
        } else {
          $arrayDiasAuxiliar[$contador] = 0;
        }
        $contador++;
      }
      array_push($arrayDiasGeneralComensales[$contadorComensales2]['diasRegistro'], $arrayDiasAuxiliar);
      $contadorDiasSeleccionados++;
    }
    $contadorComensales2++;
  }

/*   echo "<pre>";
  var_dump($arrayDiasGeneralComensales);
  echo "<pre>"; */

  /* $whereTrabajador = ($trabajador == NULL) ? "" : "WHERE PER_dni=$trabajador";
($estado == NULL)
    ? $whereOrden = "AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'"
    : $whereOrden = "AND ORD_estado='$estado' AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'";

$resConsultaPersonas = mysqli_query($conexion, "SELECT * FROM  personas $whereTrabajador"); */
//si existe registros en essas fechas
$sheet = $spreadsheet->getActiveSheet();
    $filaAfectadaColorDet2 = 'G2:L2';
    $spreadsheet->getActiveSheet()->getStyle($filaAfectadaColorDet2)->getFill()
      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
      ->getStartColor()->setARGB('F4A060');
    $sheet->setCellValue('H2', 'REPORTE NORMAL'.$idEmpresa);
    $spreadsheet->getActiveSheet()->setTitle("REPORTE NORMAL");
    if (count($arrayDiasGeneralComensales) > 0) {

    for ($i = 0; $i < 6; $i++) {
      $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$i])->setAutoSize(true);
    }
    $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
    $spreadsheet->getActiveSheet()->mergeCells('H2:L2');
    
    $rowData = 8;
    //si no hay comensales no muestra nada 
    if (count($arrayDiasRegistroComensales) > 0) {
      $sheet->setCellValue('A7', '#');
      $sheet->setCellValue('B7', 'Comedor');
           $sheet->setCellValue('C7', 'Dni');
      $sheet->setCellValue('D7', 'Nombres');
      $sheet->setCellValue('E7', 'Cargo');
      $sheet->setCellValue('F7', 'Empresa');

      $filaAfectadaColorDet = 'A7:F7';
      $spreadsheet->getActiveSheet()->getStyle($filaAfectadaColorDet)->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('F4A060');


      $sumaTotal = 0;
      //$cell = $sheet->getCellByColumnAndRow(9 + 1,11);
      //$column=10;
      $rowNombres = 5;
      $rowFecha = 6;
      $ultimaColumnData = 0;

      for ($contadorTrajadores = 0; $contadorTrajadores < count($arrayDiasGeneralComensales); $contadorTrajadores++) {
        $columnData = 7;
        $sheet->setCellValueByColumnAndRow(1, $rowData, $contadorTrajadores + 1);
        $sheet->setCellValueByColumnAndRow(2, $rowData, $arrayDiasGeneralComensales[$contadorTrajadores]['cede']);
        $sheet->setCellValueByColumnAndRow(3, $rowData, $arrayDiasGeneralComensales[$contadorTrajadores]['dni']);
        $sheet->setCellValueByColumnAndRow(4, $rowData, $arrayDiasGeneralComensales[$contadorTrajadores]['nombres']);
        $sheet->setCellValueByColumnAndRow(5, $rowData, $arrayDiasGeneralComensales[$contadorTrajadores]['cargo']);
        $sheet->setCellValueByColumnAndRow(6, $rowData, $arrayDiasGeneralComensales[$contadorTrajadores]['empresa']);

        foreach ($arrayDiasGeneralComensales[$contadorTrajadores]['diasRegistro'] as $diaRegistros) {
          foreach ($diaRegistros as $tipos) {
            $sheet->setCellValueByColumnAndRow(
              $columnData,
              $rowData,
              $tipos
            );
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
        $columnAux = $column;
        //creamos los nombres d'dias  coslpan 3
        $spreadsheet->getActiveSheet()->mergeCells($abecedario[$column] . '5' . ':' . $abecedario[$columnAux + 2] . '5');
        //creamos las fechas con coslpan 3
        $spreadsheet->getActiveSheet()->mergeCells($abecedario[$column] . '6' . ':' . $abecedario[$columnAux + 2] . '6');
        $ultimaColumnaAfectada = $abecedario[$columnAux + 2] . '6';
        $posicionUltimaColumnaAfectada = $columnAux + 2;
        //insertamos las nombres 
        $sheet->setCellValue($abecedario[$column] . '5', $arrayDiasSelecionados[$cont]['nombre']);
        //insertamos las fechas 
        $sheet->setCellValue($abecedario[$column] . '6', $arrayDiasSelecionados[$cont]['fecha']);
        //insertamos D,A,C
        $sheet->setCellValue($abecedario[$column] . '7', 'D');
        $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$column])->setWidth(4);
        $sheet->setCellValue($abecedario[$column + 1] . '7', 'A');
        $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$column + 1])->setWidth(4);
        $sheet->setCellValue($abecedario[$column + 2] . '7', 'C');
        $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$column + 2])->setWidth(4);
        $column += 3;
      }
      $filaAfectadaColor = 'G5:' . $ultimaColumnaAfectada;
      $spreadsheet->getActiveSheet()->getStyle($filaAfectadaColor)->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('F4A060');


      $posicionSiguienteColumnaAfectada = $posicionUltimaColumnaAfectada + 1;
      $arrayDescripcionTabla = ['Conteo de Atenciones', 'Valorización'];
      $ultimaColumnaFinal = '';
      for ($i = 0; $i < 3; $i++) {

        $columnAux2 = $posicionSiguienteColumnaAfectada;
        if ($i == 2) {
          $sheet->setCellValue($abecedario[$posicionSiguienteColumnaAfectada] . '6', 'TOTAL');
          $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$posicionSiguienteColumnaAfectada])->setWidth(20);
          $ultimaColumnaFinal = $abecedario[$posicionSiguienteColumnaAfectada] . '6';
          break;
        }
        //creamos los nombres d'dias  coslpan 3
        $spreadsheet->getActiveSheet()
          ->mergeCells($abecedario[$posicionSiguienteColumnaAfectada] . '6' . ':' . $abecedario[$columnAux2 + 2] . '6');

        $sheet->setCellValue($abecedario[$posicionSiguienteColumnaAfectada] . '6', $arrayDescripcionTabla[$i]);
        //insertamos D,A,C
        $sheet->setCellValue($abecedario[$posicionSiguienteColumnaAfectada] . '7', 'D');
        $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$posicionSiguienteColumnaAfectada])->setWidth(10);
        $sheet->setCellValue($abecedario[$posicionSiguienteColumnaAfectada + 1] . '7', 'A');
        $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$posicionSiguienteColumnaAfectada + 1])->setWidth(10);
        $sheet->setCellValue($abecedario[$posicionSiguienteColumnaAfectada + 2] . '7', 'C');
        $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$posicionSiguienteColumnaAfectada + 2])->setWidth(10);

        $posicionSiguienteColumnaAfectada += 3;
      }
      $filaAfectadaColorFinal = $ultimaColumnaAfectada . ':' .  $ultimaColumnaFinal;
      $spreadsheet->getActiveSheet()->getStyle($filaAfectadaColorFinal)->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('F4A060');

      $sumaTotalGeneral = 0;
      $ultimaColumnaTablaFinal = 0;
      $rowData2 = 8;
      $ultimaFilaTablaFinal = 0;

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
            $diasEnElMes
          );
          $sheet->setCellValueByColumnAndRow(
            $columnData2 + 3,
            $rowData2,
            $sumaTotalParcial
          );
          $columnData2++;
        }
        $sheet->setCellValueByColumnAndRow(
          $columnData2 + 3,
          $rowData2,
          $sumaTotalMes
        );

        $sumaTotalGeneral += $sumaTotalMes;
        $ultimaColumnaTablaFinal = $columnData2 + 3;
        $ultimaFilaTablaFinal = $rowData2;
        $rowData2++;
      }
      $totalConIgv =  $sumaTotalGeneral * (18 / 100);

      $sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal - 1, $ultimaFilaTablaFinal + 2, 'Sub. Total');
      $sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal - 1, $ultimaFilaTablaFinal + 3, '18.0% IGV');
      $sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal - 1, $ultimaFilaTablaFinal + 4, 'Total');

      $sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal, $ultimaFilaTablaFinal + 2, $sumaTotalGeneral);
      $sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal, $ultimaFilaTablaFinal + 3, $totalConIgv);
      $sheet->setCellValueByColumnAndRow($ultimaColumnaTablaFinal, $ultimaFilaTablaFinal + 4, $sumaTotalGeneral + $totalConIgv);
    }
  }else{
    $sheet->setCellValueByColumnAndRow(3, 4, "SIN REGISTROS DISPONIBLES");
  }
}
//seleeciona ver tipo de salida Adicional

if ($tipoAdicional == "true") {
  //creacion hoja nueva
  $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'REPORTE ADICIONAL');
  $spreadsheet->addSheet($myWorkSheet, 0);

  $conSalidasAdicional = "SELECT DESA_id, CEDE_descripcion, COME_dni, COME_nombres, EMPR_razonSocial, AREA_descripcion, REAL_fecha, TIAL_descripcion, DESA_precio, DESA_cantidad, DESA_total FROM detalle_salidas ds 
                          INNER JOIN tipo_alimentos ta ON ds.TIAL_id01 = ta.TIAL_id
                          INNER JOIN registros_alimentacion ra ON ds.REAL_id01 = ra.REAL_id
                          INNER JOIN cedes ce ON ra.CEDE_id01 = ce.CEDE_id
                          INNER JOIN comensales co ON ra.COME_id01 = co.COME_id
                          INNER JOIN empresas e ON co.EMPR_id01 = e.EMPR_id
                          INNER JOIN areas a ON co.AREA_id01 = a.AREA_id
                          WHERE TIAT_id01 = 2 $whereFechas $whereComensal $whereEmpresa";
  $resConSalidas = mysqli_query($conexion, $conSalidasAdicional);

  $spreadsheet->setActiveSheetIndex(0);
  for ($i = 0; $i < 13; $i++) {
    $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$i])->setAutoSize(true);
  }
  $spreadsheet->getActiveSheet()->mergeCells('F2:G2');
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->setCellValue('F2', 'REPORTE ADICIONAL');
  $sheet->getStyle('B:L')->getAlignment()->setHorizontal('center');

  $sheet->setCellValue('C4', 'Periodo: ');
  $sheet->setCellValue('C5', 'Total otras ventas: ');
  $sheet->setCellValue('D4', $fInicio);
  $sheet->setCellValue('E4', $fFinal);
  //color 
  $filaAfectadaColorDet = 'B2:L2';
  $spreadsheet->getActiveSheet()->getStyle($filaAfectadaColorDet)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('F4A060');
  //color 
  $filaAfectadaColorDet = 'B7:L7';
  $spreadsheet->getActiveSheet()->getStyle($filaAfectadaColorDet)->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('F4A060');
  $rowSegundoReporte = 7;
  $totalGeneralAdicional = 0;
  $myWorkSheet->setCellValueByColumnAndRow(2, $rowSegundoReporte, "");

  $myWorkSheet->setCellValueByColumnAndRow(2, $rowSegundoReporte, "ID");
  $myWorkSheet->setCellValueByColumnAndRow(3, $rowSegundoReporte, "Comedor");
  $myWorkSheet->setCellValueByColumnAndRow(4, $rowSegundoReporte, "DNI");
  $myWorkSheet->setCellValueByColumnAndRow(5, $rowSegundoReporte, "Nombres");
  $myWorkSheet->setCellValueByColumnAndRow(6, $rowSegundoReporte, "Empresa");
  $myWorkSheet->setCellValueByColumnAndRow(7, $rowSegundoReporte, "Cargo");
  $myWorkSheet->setCellValueByColumnAndRow(8, $rowSegundoReporte, "Fecha");
  $myWorkSheet->setCellValueByColumnAndRow(9, $rowSegundoReporte, "Alimento");
  $myWorkSheet->setCellValueByColumnAndRow(10, $rowSegundoReporte, "Precio");
  $myWorkSheet->setCellValueByColumnAndRow(11, $rowSegundoReporte, "Cantidad");
  $myWorkSheet->setCellValueByColumnAndRow(12, $rowSegundoReporte, "Total");

  if (mysqli_num_rows($resConSalidas) > 0) {
    // Attach the "My Data" worksheet as the first worksheet in the Spreadsheet object
    
    //celdas autoajustables al tamaño
    $rowSegundoReporte += 1;
    foreach ($resConSalidas as $k) {
      $totalGeneralAdicional += $k["DESA_total"];
      $myWorkSheet->setCellValueByColumnAndRow(2, $rowSegundoReporte, $k["DESA_id"]);
      $myWorkSheet->setCellValueByColumnAndRow(3, $rowSegundoReporte, $k["CEDE_descripcion"]);
      $myWorkSheet->setCellValueByColumnAndRow(4, $rowSegundoReporte, $k["COME_dni"]);
      $myWorkSheet->setCellValueByColumnAndRow(5, $rowSegundoReporte, $k["COME_nombres"]);
      $myWorkSheet->setCellValueByColumnAndRow(6, $rowSegundoReporte, $k["EMPR_razonSocial"]);
      $myWorkSheet->setCellValueByColumnAndRow(7, $rowSegundoReporte, $k["AREA_descripcion"]);
      $myWorkSheet->setCellValueByColumnAndRow(8, $rowSegundoReporte, $k["REAL_fecha"]);
      $myWorkSheet->setCellValueByColumnAndRow(9, $rowSegundoReporte, $k["TIAL_descripcion"]);
      $myWorkSheet->setCellValueByColumnAndRow(10, $rowSegundoReporte, $k["DESA_precio"]);
      $myWorkSheet->setCellValueByColumnAndRow(11, $rowSegundoReporte, $k["DESA_cantidad"]);
      $myWorkSheet->setCellValueByColumnAndRow(12, $rowSegundoReporte, $k["DESA_total"]);
      $rowSegundoReporte++;
    }
    $sheet->setCellValue('D5', number_format($totalGeneralAdicional,2));
    
  } else {
    $myWorkSheet->setCellValueByColumnAndRow(3, 8, "SIN REGISTROS DISPONIBLES");
  }
}


$conexion->close();
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte orden.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
