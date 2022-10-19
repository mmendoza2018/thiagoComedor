<?php
session_start();
require_once("../conexion.php");
date_default_timezone_set("America/Lima");

if (!isset($_SESSION['sesionTipoAlimentos'])) {
  echo json_encode([false, "Debe agregar por lo menos un alimento"]);
  die();
}
if(!isset($_POST["tipoAtencion"])) {
  echo json_encode([false, "El tipo de atencion no es valido"]);
  die();
}/* else {
  if ($_POST["tipoAtencion"]=="1") {
   if (count($_SESSION['sesionTipoAlimentos'])>1) {
    echo json_encode([false, "No es posible agregar mas de un alimento en tipo de salidas (NORMAL)"]);
    die();
   }
  }
} */

$idusuario = $_SESSION['datos_trabajador'][0]["nombres"];
$idCedeSesion = $_SESSION['datos_trabajador'][0]["idCede"];
$idComensal = (isset($_POST["idComensal"])) ? $_POST["idComensal"] : null;
$comensalNuevo = @$_POST["comensalNuevo"];
$tipoAtencion = @$_POST["tipoAtencion"];
$observacionGeneral = isset($_POST["observaciones"]) ? $_POST["observaciones"] : $comensalNuevo ;
$fechaRegistro = isset($_POST["fechaRegistro"]) ? $_POST["fechaRegistro"] : null;
if ($fechaRegistro == null) {
  $fechaActual = date("Y-m-d h:m:s");
}else {
  $fechaActual = $fechaRegistro." 00:00:00";
}
$registroTipoAlimento = ($tipoAtencion == 1) ? $_SESSION['sesionTipoAlimentos'][0]['id'] : null;
$precioTipoAlimento = ($tipoAtencion == 1) ? $_SESSION['sesionTipoAlimentos'][0]['precio'] : null;
$TipoRegistroAlimento = ($tipoAtencion == 1) ? 2 : null;
$consultaDetalles = "";
$consultaRegistrosDiarios = "";

if ($tipoAtencion == 1) {
  //verifica que no haya duplicaciones de raciones
$conExisteRegistro = "SELECT DATE(REAL_fecha) FROM registros_alimentacion ra 
WHERE DATE(REAL_fecha)='$fechaActual' AND COME_id01='$idComensal' AND TIAL_id01=$registroTipoAlimento";
  $ExisteRegistro = mysqli_query($conexion, $conExisteRegistro);
  if (mysqli_num_rows($ExisteRegistro) > 0) {
    echo json_encode([false, 'El trabajador ya recibio la ración diaria!']);
    die();
  }

  foreach ($_SESSION['sesionTipoAlimentos'] as $el) {

    $consultaRegistrosDiarios .= "INSERT INTO registros_alimentacion 
                        (	
                          COME_id01,	
                          REAL_solicitante,
                          CEDE_id01,	
                          TIAL_id01,		
                          REAL_precio_comida,	
                          TIRE_id01,	
                          TIAT_id01,
                          REAL_fecha
                        ) VALUES 
                        (
                          " . (($idComensal == null) ? "NULL" : $idComensal) . ",
                          '$observacionGeneral',
                          $idCedeSesion,
                          " . $el["id"] . ",
                          " . $el["precio"] . ",
                          " . (($TipoRegistroAlimento == null) ? "NULL" : $TipoRegistroAlimento) . ",
                          '$tipoAtencion',
                          '$fechaActual'
                        );";
  }
  echo (mysqli_multi_query($conexion, substr($consultaRegistrosDiarios, 0, -1)))
  ? json_encode([true, "agregado con exito!"])
  : json_encode([false, "Fallo al agregar1"]);

} else {

  $consultaRegistroDiario = "INSERT INTO registros_alimentacion 
                          (	
                            COME_id01,	
                            REAL_solicitante,
                            CEDE_id01,	
                            TIAL_id01,		
                            REAL_precio_comida,	
                            TIRE_id01,	
                            TIAT_id01,
                            REAL_fecha
                          ) VALUES 
                          (
                            " . (($idComensal == null) ? "NULL" : $idComensal) . ",
                            '$observacionGeneral',
                            $idCedeSesion,
                            " . (($registroTipoAlimento == null) ? "NULL" : $registroTipoAlimento) . ",
                            " . (($precioTipoAlimento == null) ? "NULL" : $precioTipoAlimento) . ",
                            " . (($TipoRegistroAlimento == null) ? "NULL" : $TipoRegistroAlimento) . ",
                            '$tipoAtencion',
                            '$fechaActual'
                          )";

    if (!mysqli_query($conexion, $consultaRegistroDiario)) {
      echo json_encode([false, "Fallo al agregar2!"]);
      die();
    }
    
    $ultimaIngreso = mysqli_query($conexion, "SELECT REAL_id FROM registros_alimentacion ORDER BY REAL_id DESC LIMIT 1");
    foreach ($ultimaIngreso as $k) {
      $idUltimoRegistro = $k["REAL_id"];
    }
    foreach ($_SESSION['sesionTipoAlimentos'] as $el) {

      $total =  $el["precio"] * $el["cantidad"];
      $consultaDetalles .= "INSERT INTO detalle_salidas 
                            ( 
                              REAL_id01,	
                              TIAL_id01,		
                              DESA_precio,	
                              DESA_cantidad,		
                              DESA_total
                            ) 
                            VALUES 
                            (    
                              '$idUltimoRegistro',
                              " . $el["id"] . ",
                              " . $el["precio"] . ",
                              " . $el["cantidad"] . ",
                              " . $total . "
                            );";
    }
    echo (mysqli_multi_query($conexion, substr($consultaDetalles, 0, -1)))
    ? json_encode([true, "agregado con exito!"])
    : json_encode([false, "Fallo al agregar2"]);
}
mysqli_close($conexion);
