<?php 
session_start();
require_once("../../conexion.php");

$AREA_id = @$_POST["AREA_id"];
$AREA_descripcion = @$_POST["AREA_descripcion"];
$AREA_estado = @$_POST["AREA_estado"];

$consulta="UPDATE areas SET AREA_descripcion='$AREA_descripcion', AREA_estado='$AREA_estado' WHERE AREA_id='$AREA_id';";
$updateCargo = mysqli_query($conexion,$consulta);
echo ($updateCargo) ? json_encode(true) : json_encode(false) ;  
$conexion->close();

?>