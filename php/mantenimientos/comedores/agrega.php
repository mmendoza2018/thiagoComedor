<?php 
session_start();
require_once("../../conexion.php");

$descripcionComedor = @$_POST["descripcionComedor"];

$consulta = "INSERT INTO cedes (CEDE_descripcion) VALUES ('$descripcionComedor')";
$addComedor = mysqli_query($conexion,$consulta);
echo ($addComedor) ? json_encode(true) : json_encode(false) ; 
$conexion->close();
?>