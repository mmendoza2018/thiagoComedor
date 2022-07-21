<?php
require_once("../conexion.php");
require '../../assets/plugins/spreadSheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$trabajador = @$_GET["trabajador"];
$fInicio = @$_GET["fInicio"];
$fFinal = @$_GET["fFinal"];
$estado = @$_GET["estado"];
$idOrden = 1;
$whereOrden = "";
$whereTrabajador = ($trabajador == NULL) ? "" : "WHERE PER_dni=$trabajador";
($estado == NULL)
    ? $whereOrden = "AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'"
    : $whereOrden = "AND ORD_estado='$estado' AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'";

$resConsultaPersonas = mysqli_query($conexion, "SELECT * FROM  personas $whereTrabajador");
$spreadsheet = new Spreadsheet();

$letras = "a-b-c-d-e-f-g-h-i-j-k-l";
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

$resConDetalleOrden = mysqli_query($conexion, "SELECT *,DATE(ORD_fecha_creacion) as fecha, SUM(DEOR_monto) as sumaDebes, sum(if(ORD_tipomoneda = 'SOLES',DEOR_monto,0)) as sumaSoles,sum(if(ORD_tipomoneda = 'DOLARES',DEOR_monto,0)) as sumaDolares FROM detalleorden do INNER JOIN ordenes o ON do.ORD_id01 = o.ORD_id INNER JOIN centros_costo cc ON cc.CECO_id=o.CECO_id01 INNER JOIN personas p ON p.PER_id=o.PER_id01 $whereTrabajador AND DEOR_operacion='DEBE' $whereOrden GROUP BY ORD_id");
$sumaTotal = 0;
$sumaSoles= 0;
$sumaDolares =0;
$contadorRegistrosPorOrden = 9;
foreach ($resConDetalleOrden as $f) {
    $sumaTotal += $f["sumaDebes"];
    $sumaSoles += $f["sumaSoles"];
    $sumaDolares += $f["sumaDolares"];
    $sheet->setCellValue('A' . $contadorRegistrosPorOrden, $f["ORD_id"]);
    $sheet->setCellValue('B' . $contadorRegistrosPorOrden, $f["PER_nombres"]);
    $sheet->setCellValue('C' . $contadorRegistrosPorOrden, $f["ORD_motivo"]);
    $sheet->setCellValue('D' . $contadorRegistrosPorOrden, $f["CECO_descripcion"]);
    $sheet->setCellValue('E' . $contadorRegistrosPorOrden, $f["ORD_tipomoneda"]);
    $sheet->setCellValue('F' . $contadorRegistrosPorOrden, $f["sumaDebes"]);
    $sheet->setCellValue('G' . $contadorRegistrosPorOrden, $f["ORD_fecha_creacion"]);
    $sheet->setCellValue('H' . $contadorRegistrosPorOrden, $f["ORD_aprobacion1"]);
    $sheet->setCellValue('I' . $contadorRegistrosPorOrden, $f["ORD_aprofecha1"]);
    $sheet->setCellValue('J' . $contadorRegistrosPorOrden, $f["ORD_numtransaccion"]);
    $sheet->setCellValue('K' . $contadorRegistrosPorOrden, $f["ORD_fechatransaccion"]);
    $sheet->setCellValue('L' . $contadorRegistrosPorOrden, $f["ORD_estado"]);
    $contadorRegistrosPorOrden++;
}
$sheet->setCellValue('E' . $contadorRegistrosPorOrden, 'S. SOLES');
$sheet->setCellValue('E' . ($contadorRegistrosPorOrden+1), 'S. DOLARES');
$sheet->setCellValue('E' . ($contadorRegistrosPorOrden+2), 'S. TOTAL');
$sheet->setCellValue('F' . $contadorRegistrosPorOrden, $sumaSoles);
$sheet->setCellValue('F' . ($contadorRegistrosPorOrden+1), $sumaDolares);
$sheet->setCellValue('F' . ($contadorRegistrosPorOrden+2), $sumaTotal);
$conexion->close();
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte orden.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
