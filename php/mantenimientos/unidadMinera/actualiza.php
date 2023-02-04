<?php 
require_once("../../conexion.php");

$idAct = @$_POST["idAct"];
$descripcionAct = @$_POST["descripcionAct"];
$estadoAct = @$_POST["estadoAct"];

$consulta="UPDATE unidad_minera SET UNMI_descripcion='$descripcionAct', UNMI_estado='$estadoAct' WHERE UNMI_id='$idAct'";
$update = mysqli_query($conexion,$consulta);
echo ($update) ? json_encode(true) : json_encode(false);

$conexion->close();

?>