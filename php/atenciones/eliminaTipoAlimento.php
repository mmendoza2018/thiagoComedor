<?php 
session_start();
$indiceTipoAlimento = $_POST["indiceTipoAlimento"];
unset($_SESSION['sesionTipoAlimentos'][$indiceTipoAlimento]);
$arrayTipoAlimentos = array_values($_SESSION['sesionTipoAlimentos']);
unset($_SESSION['sesionTipoAlimentos']);
$_SESSION['sesionTipoAlimentos']=$arrayTipoAlimentos;
echo json_encode(true);
?>