<?php
require_once("../../conexion.php");
require '../../../assets/plugins/spreadSheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$idUnidadMinera = @$_GET["idUnidadMinera"];
$idTipoDocumento = @$_GET["idTipoDocumento"];
$unidadMinera = @$_GET["unidadMinera"];
$tipoDocumento = @$_GET["tipoDocumento"];
$fInicio = @$_GET["fInicio"];
$fFinal = @$_GET["fFinal"];

$whereFechas = "AND (DATE(DOCU_fecha_vencimiento) BETWEEN '$fInicio' AND '$fFinal')";

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
$sheet->setCellValue('B2', 'REPORTE DOCUMENTOS VENCIMIENTO');
$spreadsheet->getActiveSheet()->setTitle("Pagina 1");

$sheet->setCellValue('C4', 'Periodo: ');
$sheet->setCellValue('C5', 'Total documentos: ');
$sheet->setCellValue('F4', 'Unidad minera: ');
$sheet->setCellValue('F5', 'Tipo Documentos: ');
$sheet->setCellValue('D4', $fInicio);
$sheet->setCellValue('E4', $fFinal);
$sheet->setCellValue('G4', $unidadMinera);
$sheet->setCellValue('G5', $tipoDocumento);

$sheet->setCellValue('B7', '#');
$sheet->setCellValue('C7', 'DNI');
$sheet->setCellValue('D7', 'Nombres');
$sheet->setCellValue('E7', 'Unidad minera');
$sheet->setCellValue('F7', 'Tipo documento');
$sheet->setCellValue('G7', 'Fecha ingreso');
$sheet->setCellValue('H7', 'Fecha vencimiento');
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

if ($idUnidadMinera != "") {
  if ($idTipoDocumento != "") {
    $consulta = "SELECT * FROM documentos doc 
                   LEFT JOIN tipo_documentos td ON doc.TIDO_id01 = td.TIDO_id 
                   LEFT JOIN personas pe ON doc.PER_id01 = pe.PER_id 
                   LEFT JOIN unidad_minera um ON pe.UNMI_id01 = um.UNMI_id 
                   WHERE DOCU_estado = 1 AND UNMI_id01 = $idUnidadMinera AND TIDO_id01 = $idTipoDocumento $whereFechas";
  } else {
    $consulta = "SELECT * FROM documentos doc 
                LEFT JOIN tipo_documentos td ON doc.TIDO_id01 = td.TIDO_id 
                LEFT JOIN personas pe ON doc.PER_id01 = pe.PER_id 
                LEFT JOIN unidad_minera um ON pe.UNMI_id01 = um.UNMI_id 
                WHERE DOCU_estado = 1 AND UNMI_id01 = $idUnidadMinera $whereFechas";
  }
} else {
  if ($idTipoDocumento != "") {
    $consulta = "SELECT * FROM documentos doc 
    LEFT JOIN tipo_documentos td ON doc.TIDO_id01 = td.TIDO_id 
                 LEFT JOIN personas pe ON doc.PER_id01 = pe.PER_id 
                 LEFT JOIN unidad_minera um ON pe.UNMI_id01 = um.UNMI_id 
                 WHERE DOCU_estado = 1 AND TIDO_id01 = $idTipoDocumento $whereFechas";
  } else {
    $consulta = "SELECT * FROM documentos doc 
              LEFT JOIN tipo_documentos td ON doc.TIDO_id01 = td.TIDO_id 
              LEFT JOIN personas pe ON doc.PER_id01 = pe.PER_id 
              LEFT JOIN unidad_minera um ON pe.UNMI_id01 = um.UNMI_id 
              WHERE DOCU_estado = 1 $whereFechas";
  }
}
/* echo $consulta;
die(); */
$resDocumentos = mysqli_query($conexion, $consulta);
if (mysqli_num_rows($resDocumentos) > 0) {
  $rowReporte = 8;
  $contador = 1;
  foreach ($resDocumentos as $k) {
    $sheet->setCellValueByColumnAndRow(2, $rowReporte, $contador);
    $sheet->setCellValueByColumnAndRow(3, $rowReporte, $k["PER_usuario"]);
    $sheet->setCellValueByColumnAndRow(4, $rowReporte, $k["PER_nombres"] ." ".$k["PER_apellidos"]);
    $sheet->setCellValueByColumnAndRow(5, $rowReporte, $k["UNMI_descripcion"]);
    $sheet->setCellValueByColumnAndRow(6, $rowReporte, $k["TIDO_descripcion"]);
    $sheet->setCellValueByColumnAndRow(7, $rowReporte, $k["DOCU_fecha_ingreso"]);
    $sheet->setCellValueByColumnAndRow(8, $rowReporte, $k["DOCU_fecha_vencimiento"]);
    $rowReporte++;
    $contador++;
  }
  $sheet->setCellValue('D5', mysqli_num_rows($resDocumentos));
} else {
  $sheet->setCellValueByColumnAndRow(3, 8, 'SIN REGISTROS DISPONIBLES');
}

$conexion->close();
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte documentos.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
