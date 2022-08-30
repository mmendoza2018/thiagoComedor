<?php
require_once("../../conexion.php");
require '../../../assets/plugins/spreadSheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$fecha = @$_GET["fecha"];

$spreadsheet = new Spreadsheet();

$abecedario = [
  'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
  'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
  'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ',
  'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ',
  'DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ',
  'EA', 'EB', 'EC', 'ED', 'EE', 'EF', 'EG', 'EH', 'EI', 'EJ', 'EK', 'EL', 'EM', 'EN', 'EO', 'EP', 'EQ', 'ER', 'ES', 'ET', 'EU', 'EV', 'EW', 'EX', 'EY', 'EZ',
  'FA', 'FB', 'FC', 'FD', 'FE', 'FF', 'FG', 'FH', 'FI', 'FJ', 'FK', 'FL', 'FM', 'FN', 'FO', 'FP', 'FQ', 'FR', 'FS', 'FT', 'FU', 'FV', 'FW', 'FX', 'FY'
];
for ($i = 0; $i < 5; $i++) {
  $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$i])->setAutoSize(true);
}
$spreadsheet->getActiveSheet()->mergeCells('B2:C2');
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('B2', 'Fecha de ajuste:');
$spreadsheet->getActiveSheet()->setTitle("Ajustes");

$sheet->setCellValue('D2', $fecha);
$sheet->setCellValue('B4', '# Comensal');
$sheet->setCellValue('C4', 'DNI');
$sheet->setCellValue('D4', 'Nombres');
$sheet->setCellValue('E4', '# Alimento');
//alinear celdas
$sheet->getStyle('B:E')->getAlignment()->setHorizontal('center');

$filaAfectadaColorDet = 'B4:E4';
$spreadsheet->getActiveSheet()->getStyle($filaAfectadaColorDet)->getFill()
->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
->getStartColor()->setARGB('F4A060');


$arregloListaAjustes = [];
$consultaComensales = "SELECT COME_id,COME_nombres,COME_dni FROM comensales WHERE COME_estado = 1 ORDER BY EMPR_id01 ASC ";
foreach (mysqli_query($conexion, $consultaComensales) as $k) {
  $consultaRegistroAl = "SELECT * FROM registros_alimentacion WHERE TIAT_id01= 1 AND COME_id01 = ".$k["COME_id"]." AND DATE(REAL_fecha) ='$fecha'";
  $resRegistroAl = mysqli_query($conexion, $consultaRegistroAl );
  $numIngresos = mysqli_num_rows($resRegistroAl);
  if ($numIngresos > 0 && $numIngresos < 3) {
    $consultaTipoAl = "SELECT * FROM tipo_alimentos WHERE TIAL_estado = 1 AND TIAL_principal=1";
    foreach (mysqli_query($conexion, $consultaTipoAl) as $x) {
      $registroFaltante = true;
      foreach ($resRegistroAl as $t) {
        if ($x["TIAL_id"] == $t["TIAL_id01"]) {
          $registroFaltante = false;
        }
      }
      if ($registroFaltante) {
        array_push($arregloListaAjustes, [
          "idComensal" => $k["COME_id"],
          "dni" => $k["COME_dni"],
          "nombres" => $k["COME_nombres"],
          "idAlimentacion" => $x["TIAL_id"]
        ]);
      }
    }
  }
}
if (count($arregloListaAjustes)>0) {
  $rowReporte = 5;
  foreach ($arregloListaAjustes as $k) {
    $sheet->setCellValueByColumnAndRow(2, $rowReporte, $k["idComensal"]);
    $sheet->setCellValueByColumnAndRow(3, $rowReporte, $k["dni"]);
    $sheet->setCellValueByColumnAndRow(4, $rowReporte, $k["nombres"]);
    $sheet->setCellValueByColumnAndRow(5, $rowReporte, $k["idAlimentacion"]);
    $rowReporte++;
  }
}else {
  $spreadsheet->getActiveSheet()->mergeCells('B5:D5');
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->setCellValue('B5', 'Sin ajustes a realizar');
}

$conexion->close();
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Ajustes.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
