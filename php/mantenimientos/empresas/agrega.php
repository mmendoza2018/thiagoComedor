<?php 
session_start();
require_once("../../conexion.php");

$descripcionRazonSocial = @$_POST["descripcionRazonSocial"];
$numeroRuc = @$_POST["numeroRuc"];

$consulta = "INSERT INTO empresas (EMPR_razonSocial,EMPR_ruc) VALUES ('$descripcionRazonSocial','$numeroRuc')";
$addEmpresa = mysqli_query($conexion,$consulta);
echo ($addEmpresa) ? json_encode(true) : json_encode(false) ; 
$conexion->close();
?>