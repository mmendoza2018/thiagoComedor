<?php 
session_start();
require_once("../../conexion.php");

$TIRE_id = @$_POST["TIRE_id"];
$TIRE_descripcion = @$_POST["TIRE_descripcion"];
$TIRE_estado = @$_POST["TIRE_estado"];

$consulta="UPDATE tipos_registro SET TIRE_descripcion='$TIRE_descripcion', TIRE_estado='$TIRE_estado' WHERE TIRE_id='$TIRE_id';";
$updateTipoRegistro = mysqli_query($conexion,$consulta);
echo ($updateTipoRegistro) ? json_encode(true) : json_encode(false) ;  
$conexion->close();

?>