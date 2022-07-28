<?php 
session_start();
require_once("../../conexion.php");

$CEDE_id = @$_POST["CEDE_id"];
$CEDE_descripcion = @$_POST["CEDE_descripcion"];
$CEDE_estado = @$_POST["CEDE_estado"];

$consulta="UPDATE cedes SET CEDE_descripcion='$CEDE_descripcion', CEDE_estado='$CEDE_estado' WHERE CEDE_id='$CEDE_id';";
$updateComedor = mysqli_query($conexion,$consulta);
echo ($updateComedor) ? json_encode(true) : json_encode(false) ;  
$conexion->close();

?>