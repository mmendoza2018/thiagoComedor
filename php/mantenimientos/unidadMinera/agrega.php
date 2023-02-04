<?php 
session_start();
require_once("../../conexion.php");

$descripcion = @$_POST["descripcion"];

$consulta = "INSERT INTO unidad_minera (UNMI_descripcion) VALUES ('$descripcion')";
$addUnidadMinera = mysqli_query($conexion,$consulta);

echo ($addUnidadMinera) ? json_encode(true) : json_encode(false);

$conexion->close();
?>