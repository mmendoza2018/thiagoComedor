<?php 
session_start();
require_once("../../conexion.php");

$descripcion = @$_POST["descripcion"];

$consulta = "INSERT INTO areas (AREA_descripcion) VALUES ('$descripcion')";
$addCargo = mysqli_query($conexion,$consulta);
echo ($addCargo) ? json_encode(true) : json_encode(false) ; 
$conexion->close();
?>