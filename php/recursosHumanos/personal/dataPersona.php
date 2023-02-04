<?php 
require_once "../../conexion.php";

$idPersona = @$_POST["idPersona"];
$resPersona = mysqli_query($conexion, "SELECT * FROM personas WHERE PER_id=$idPersona AND PER_estado = 1");
$arrayPersona = mysqli_fetch_assoc($resPersona);

echo json_encode($arrayPersona);
?>