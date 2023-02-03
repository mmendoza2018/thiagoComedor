<?php 
require_once("../../conexion.php");

$idAct = @$_POST["idAct"];
$descripcionAct = @$_POST["descripcionAct"];
$estadoAct = @$_POST["estadoAct"];

$consulta="UPDATE tipo_documentos SET TIDO_descripcion='$descripcionAct', TIDO_estado='$estadoAct' WHERE TIDO_id='$idAct';";
$update = mysqli_query($conexion,$consulta);
echo ($update) ? json_encode(true) : json_encode(false);

$conexion->close();

?>