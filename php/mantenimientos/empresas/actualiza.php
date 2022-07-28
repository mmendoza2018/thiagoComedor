<?php 
session_start();
require_once("../../conexion.php");

$EMPR_id = @$_POST["EMPR_id"];
$EMPR_razonSocial = @$_POST["EMPR_razonSocial"];
$EMPR_ruc = @$_POST["EMPR_ruc"];
$EMPR_estado = @$_POST["EMPR_estado"];

$consulta="UPDATE empresas SET EMPR_razonSocial='$EMPR_razonSocial', EMPR_ruc='$EMPR_ruc', EMPR_estado='$EMPR_estado' WHERE EMPR_id='$EMPR_id';";
$updateEmpresa = mysqli_query($conexion,$consulta);
echo ($updateEmpresa) ? json_encode(true) : json_encode(false) ;  
$conexion->close();

?>