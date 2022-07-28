<?php 
session_start();
require_once("../../conexion.php");

$TIAT_id = @$_POST["TIAT_id"];
$TIAT_descripcion = @$_POST["TIAT_descripcion"];
$TIAT_estado = @$_POST["TIAT_estado"];

$consulta="UPDATE tipos_atencion SET TIAT_descripcion='$TIAT_descripcion', TIAT_estado='$TIAT_estado' WHERE TIAT_id='$TIAT_id';";
$updateTipoAtencion = mysqli_query($conexion,$consulta);
echo ($updateTipoAtencion) ? json_encode(true) : json_encode(false) ;  
$conexion->close();

?>