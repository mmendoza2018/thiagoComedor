<?php 
session_start();
require_once("../../conexion.php");

$descripcionTipoRegistro = @$_POST["descripcionTipoRegistro"];

$consulta = "INSERT INTO tipos_registro (TIRE_descripcion) VALUES ('$descripcionTipoRegistro')";
$addTipoRegistro = mysqli_query($conexion,$consulta);
echo ($addTipoRegistro) ? json_encode(true) : json_encode(false) ; 
$conexion->close();
?>