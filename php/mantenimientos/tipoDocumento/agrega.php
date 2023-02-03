<?php 
session_start();
require_once("../../conexion.php");

$descripcion = @$_POST["descripcion"];

$consulta = "INSERT INTO tipo_documentos (TIDO_descripcion) VALUES ('$descripcion');";
$addDocEquipo = mysqli_query($conexion,$consulta);

echo ($addDocEquipo) ? json_encode(true) : json_encode(false);

$conexion->close();
?>