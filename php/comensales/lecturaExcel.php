<?php

require '../../assets/plugins/spreadSheet/vendor/autoload.php';
require_once("../conexion.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$idEmpresa = $_POST["idEmpresa"];
$archivoExcel = $_FILES["archivoExcel"];
/**  Define a Read Filter class implementing \PhpOffice\PhpSpreadsheet\Reader\IReadFilter  */
class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
  public function readCell($columnAddress, $row, $worksheetName = '')
  {
    //  Read rows 1 to 7 and columns A to E only
    if ($row >= 4) {
      if (in_array($columnAddress, range('B', 'D')))  return true;
    }
    return false;
  }
}
/**  Create an Instance of our Read Filter  **/
$filterSubset = new MyReadFilter();

/**  Create a new Reader of the type defined in $inputFileType  **/
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$reader->setReadFilter( new MyReadFilter() );
$spreadsheet = $reader->load($archivoExcel['tmp_name']);
/**  Tell the Reader that we want to use the Read Filter  **/
$data = $spreadsheet->getActiveSheet()->toArray();
/* echo "<pre>";
var_dump($data);
echo "<pre>"; */
if ($data[3][1] == null || $data[4][1] == null) {
  echo json_encode([false, "Los registros no fueron ubicados"]);
  die();
}

$consultaComensales = "SELECT COME_dni FROM comensales WHERE EMPR_id01='$idEmpresa' AND COME_estado = 1";
$resComensales = mysqli_query($conexion, $consultaComensales);
$arrayNuevosComensales = [];
foreach ($data as $k) {
  $comensalRepetido = false;
  foreach ($resComensales as $t) {
    if ($k[1] == null || $k[1] == $t["COME_dni"]) {
      $comensalRepetido = true;
      break;
    }
  }
  if ($comensalRepetido == false) {
    array_push($arrayNuevosComensales, ["dni" => $k[1], "nombres" => $k[2], "cargo" => $k[3]]);
  }
}

if (count($arrayNuevosComensales) <= 0) {
  echo json_encode([false, "todos los comensales ya fueron previamente registrados!"]);
  die();
}
foreach ($arrayNuevosComensales as $x) {
  $dni = $x['dni'];
  $consultaAdd = "INSERT INTO comensales (
                                        COME_nombres,	
                                        COME_dni,	
                                        EMPR_id01,	
                                        AREA_id01
                                        ) VALUES 
                                        (
                                        '" . $x["nombres"] . "',
                                        '" . $x["dni"] . "',
                                        '$idEmpresa',
                                        " . $x["cargo"] . "
                                        )";
  if (!mysqli_query($conexion, $consultaAdd)) {
    echo json_encode([false, "El comensal con DNI $dni  no pudo ser registrado, Revise que el cargo sea el correcto"]);
    die();
  }
}
echo json_encode([true,null]);
