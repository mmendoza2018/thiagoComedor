<?php 
session_start();
require_once("../../conexion.php");

$horaInicio = @$_POST["horaInicio"];
$horaFinal = @$_POST["horaFinal"];
$tipoAlimento = @$_POST["tipoAlimento"];

$consulta = "INSERT INTO horarios (HORA_inicio,HORA_final,TIAL_id01) VALUES ('$horaInicio','$horaFinal','$tipoAlimento')";
$addHorarios = mysqli_query($conexion,$consulta);
echo ($addHorarios) ? json_encode(true) : json_encode(false) ; 
$conexion->close();
?>