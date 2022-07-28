<?php 
session_start();
require_once("../../conexion.php");

$descripcionAlimento = @$_POST["descripcionAlimento"];
$marcaAlimento = @$_POST["marcaAlimento"];
$unidadAlimento = @$_POST["unidadAlimento"];
$precioAlimento = @$_POST["precioAlimento"];
$tipoAlimento = @$_POST["tipoAlimento"];
$usuario = $_SESSION["datos_trabajador"][0]["nombres"];

$consulta = "INSERT INTO tipo_alimentos (TIAL_descripcion, TIAL_marca,TIAL_unidad,TIAL_precio,TIAL_principal,TIAL_usuario) VALUES ('$descripcionAlimento','$marcaAlimento','$unidadAlimento','$precioAlimento','$tipoAlimento','$usuario')";
$addAlimento = mysqli_query($conexion,$consulta);
echo ($addAlimento) ? json_encode(true) : json_encode(false) ; 
$conexion->close();
?>