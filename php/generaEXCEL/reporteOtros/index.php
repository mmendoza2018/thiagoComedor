<?php
require_once("../../conexion.php");
require '../../../assets/plugins/spreadSheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$fInicio = @$_GET["fInicio"];
$fFinal = @$_GET["fFinal"];
//$estado = @$_GET["estado"];
$idOrden = 1;
$whereFechas = ($fInicio != "" && $fFinal != "")
  ? "AND (DATE(REAL_fecha) BETWEEN '$fInicio' AND '$fFinal')"
  : "";

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
for ($i = 0; $i < 9; $i++) {
  $spreadsheet->getActiveSheet()->getColumnDimension($abecedario[$i])->setAutoSize(true);
}
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$spreadsheet->getActiveSheet()->mergeCells('B2:H2');
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('B2', 'REPORTE OTRAS VENTAS');
$spreadsheet->getActiveSheet()->setTitle("REPORTE OTROS");

$sheet->setCellValue('C4', 'Periodo: ');
$sheet->setCellValue('C5', 'Total otras ventas: ');
$sheet->setCellValue('D4', $fInicio);
$sheet->setCellValue('E4', $fFinal);

$sheet->setCellValue('B7', '#');
$sheet->setCellValue('C7', 'Fecha');
$sheet->setCellValue('D7', 'Comedor');
$sheet->setCellValue('E7', 'Solicitante');
$sheet->setCellValue('F7', 'Precio');
$sheet->setCellValue('G7', 'Cantidad');
$sheet->setCellValue('H7', 'Total');
$sheet->setCellValue('I7', 'Movimiento');
//alinear celdas
$sheet->getStyle('B:H')->getAlignment()->setHorizontal('center');

$filaAfectadaColorDet = 'B7:I7';
$spreadsheet->getActiveSheet()->getStyle($filaAfectadaColorDet)->getFill()
->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
->getStartColor()->setARGB('F4A060');
$filaAfectadaColorDet2 = 'B2:I2';
$spreadsheet->getActiveSheet()->getStyle($filaAfectadaColorDet2)->getFill()
->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
->getStartColor()->setARGB('F4A060');
$consulta = "SELECT DESA_id, REAL_fecha,CEDE_descripcion, TIAL_descripcion, DESA_precio, DESA_cantidad, DESA_total
  FROM detalle_salidas ds 
  INNER JOIN tipo_alimentos tal ON ds.TIAL_id01 = tal.TIAL_id
  INNER JOIN registros_alimentacion ra ON ds.REAL_id01 = ra.REAL_id
  INNER JOIN tipos_atencion tat ON ra.TIAT_id01 = tat.TIAT_id
  INNER JOIN cedes ce ON ra.CEDE_id01 = ce.CEDE_id
  WHERE TIAT_id01 = 3 AND REAL_estado=1 $whereFechas";

$resConSalidas = mysqli_query($conexion, $consulta);
if (mysqli_num_rows($resConSalidas)>0) {
  $totalGeneralOtros = 0;
  $rowReporte = 8;
  $contador = 1;
  foreach ($resConSalidas as $k) {
    $totalGeneralOtros += $k["DESA_total"];
    $sheet->setCellValueByColumnAndRow(2, $rowReporte, $contador);
    $sheet->setCellValueByColumnAndRow(3, $rowReporte, $k["REAL_fecha"]);
    $sheet->setCellValueByColumnAndRow(4, $rowReporte, $k["CEDE_descripcion"]);
    $sheet->setCellValueByColumnAndRow(5, $rowReporte, $k["TIAL_descripcion"]);
    $sheet->setCellValueByColumnAndRow(6, $rowReporte, $k["DESA_precio"]);
    $sheet->setCellValueByColumnAndRow(7, $rowReporte, $k["DESA_cantidad"]);
    $sheet->setCellValueByColumnAndRow(8, $rowReporte, $k["DESA_total"]);
    $sheet->setCellValueByColumnAndRow(9, $rowReporte, 'OTROS');
    $rowReporte++;
    $contador++;
  }
  $sheet->setCellValue('D5', $totalGeneralOtros);
}else {
  $sheet->setCellValueByColumnAndRow(3, 8, 'SIN REGISTROS DISPONIBLES');
}

$conexion->close();
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte Otros.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
