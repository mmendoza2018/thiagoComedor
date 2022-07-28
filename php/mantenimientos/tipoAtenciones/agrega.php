<?php 
session_start();
require_once("../../conexion.php");

$descripcionTipoAtencion = @$_POST["descripcionTipoAtencion"];

$consulta = "INSERT INTO tipos_atencion (TIAT_descripcion) VALUES ('$descripcionTipoAtencion')";
$addTipoAtencion = mysqli_query($conexion,$consulta);
echo ($addTipoAtencion) ? json_encode(true) : json_encode(false) ; 
$conexion->close();
?>