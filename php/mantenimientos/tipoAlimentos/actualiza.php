<?php 
session_start();
require_once("../../conexion.php");

$TIAL_id = @$_POST["TIAL_id"];
$TIAL_descripcion = @$_POST["TIAL_descripcion"];
$TIAL_marca = @$_POST["TIAL_marca"];
$TIAL_unidad = @$_POST["TIAL_unidad"];
$TIAL_precio = @$_POST["TIAL_precio"];
$TIAL_principal = 0;
$TIAL_estado = @$_POST["TIAL_estado"];
$TIAL_usuario = $_SESSION["datos_trabajador"][0]["nombres"];

$consulta="UPDATE tipo_alimentos SET TIAL_descripcion='$TIAL_descripcion', TIAL_marca='$TIAL_marca', TIAL_unidad='$TIAL_unidad', TIAL_precio='$TIAL_precio', TIAL_principal='$TIAL_principal', TIAL_usuario='$TIAL_usuario', TIAL_estado='$TIAL_estado' WHERE TIAL_id='$TIAL_id';";
$updateTipoAlimento = mysqli_query($conexion,$consulta);
echo ($updateTipoAlimento) ? json_encode(true) : json_encode(false) ;  
$conexion->close();

?>