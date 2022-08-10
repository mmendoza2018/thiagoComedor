<?php 
session_start();
require_once("../../conexion.php");

$HORA_id = @$_POST["HORA_id"];
$HORA_inicio = @$_POST["HORA_inicio"];
$HORA_final = @$_POST["HORA_final"];
$HORA_estado = @$_POST["HORA_estado"];

$consulta="UPDATE horarios SET HORA_inicio='$HORA_inicio', HORA_final='$HORA_final', HORA_estado='$HORA_estado' WHERE HORA_id=$HORA_id";
$updateHorario = mysqli_query($conexion,$consulta);
echo ($updateHorario) ? json_encode(true) : json_encode(false) ;  
$conexion->close();

?>