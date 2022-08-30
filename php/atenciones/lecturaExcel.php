<?php
session_start();

require '../../assets/plugins/spreadSheet/vendor/autoload.php';
require_once("../conexion.php");
date_default_timezone_set("America/Lima");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$idCede = $_SESSION["datos_trabajador"][0]["idCede"];
$archivoExcel = $_FILES["archivoExcel"];
$hoy = date("Y-m-d")." 00:00:00";

/**  Define a Read Filter class implementing \PhpOffice\PhpSpreadsheet\Reader\IReadFilter  */
class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
  public function readCell($columnAddress, $row, $worksheetName = '')
  {
    //  Read rows 1 to 7 and columns A to E only
    if ($row >= 2) {
      if (in_array($columnAddress, range('B', 'E')))  return true;
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
$fechaRegistro = $data[1][3];

if ($data[3][4] == null || $data[4][4] == null) {
  echo json_encode([false, "Los registros no fueron ubicados","error"]);
  die();
}
$resListaAlimentos = mysqli_query($conexion, "SELECT TIAL_precio,TIAL_id FROM tipo_alimentos WHERE TIAL_principal = 1 AND TIAL_estado = 1");
$newData = [];
for ($i=0; $i < count($data) ; $i++) { 
  foreach ($resListaAlimentos as $y) {
    if($data[$i][4] == $y["TIAL_id"] && $data[$i] >= 4){
      array_push($newData, [
        "idComensal" => $data[$i][1],
        "dni" => $data[$i][2],
        "idAlimento" => $data[$i][4],
        "precio" => $y["TIAL_precio"]
      ]);
      break;
    }
  }
}
$consultaSalidas= "SELECT COME_id01,TIAL_id01 FROM registros_alimentacion 
                  WHERE DATE(REAL_fecha)='$fechaRegistro' AND REAL_estado= 1 AND TIAT_id01 = 1 AND CEDE_id01='$idCede'";
$resSalidas = mysqli_query($conexion, $consultaSalidas);
$arrayNuevosAjustes = [];
$contador = 0;
$contador2 = 0;
if (mysqli_num_rows($resSalidas) >0 ) {
  foreach ($newData as $k) {
    $salidaRepetida = false;
    $precioAlimento = 0;
    foreach ($resSalidas as $t) {
      if ($k["idComensal"] == $t["COME_id01"] && $k["idAlimento"] == $t["TIAL_id01"]) {
        $salidaRepetida = true;
        break;
      }
    }
    if ($salidaRepetida == false) {
      array_push($arrayNuevosAjustes, [
        "idComensal" => $k["idComensal"],
        "dni" => $k["dni"],
        "idAlimento" => $k["idAlimento"],
        "precio" => $k["precio"],
      ]);
    }
    $contador ++;
  }
}else {
  foreach ($newData as $k) {
    if ($contador2 >= 4) {
      array_push($arrayNuevosAjustes, [
        "idComensal" => $k["idComensal"],
        "dni" => $k["dni"],
        "idAlimento" => $k["idAlimento"],
        "precio" => $k["precio"],
        ]);
    }
    $contador2++;
  }
}

if (count($arrayNuevosAjustes) <= 0) {
  echo json_encode([false, "todos los ajustes ya fueron previamente registrados!","warning"]);
  die();
}

$fechaRegistro.=" 00:00:00";
foreach ($arrayNuevosAjustes as $x) {
  $dni = $x['dni'];
  $consultaAdd = "INSERT INTO registros_alimentacion (
                                        COME_id01,
                                        CEDE_id01,
                                        TIAL_id01,
                                        REAL_precio_comida,
                                        TIRE_id01,
                                        TIAT_id01,
                                        REAL_fecha,
                                        REAL_fecha_ajuste,
                                        REAL_carga_masiva
                                        ) VALUES 
                                        (
                                        " . $x["idComensal"] . ",
                                        " . $idCede . ",
                                        " . $x["idAlimento"] . ",
                                        " . $x["precio"] . ",
                                        '1',
                                        '1',
                                        '$fechaRegistro',
                                        '$hoy',
                                        '1'
                                        )";
  if (!mysqli_query($conexion, $consultaAdd)) {
    echo json_encode([false, "El comensal con DNI $dni  no pudo ser registrado, Revise que el cargo o # comensal sean los correctos","error"]);
    die();
  }
}
echo json_encode([true,null,null]);
