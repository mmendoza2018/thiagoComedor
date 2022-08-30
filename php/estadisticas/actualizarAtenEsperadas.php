<?php 
session_start();
require_once("../conexion.php");
date_default_timezone_set("America/Lima");
$usuario = $_SESSION['datos_trabajador'][0]["nombres"];
$fechaReferencia = @$_POST["fechaReferencia"];
$idAtencionEsperada = @$_POST["idAtencionEsperada"];
$desayunos = @$_POST["desayunos"];
$almuerzos = @$_POST["almuerzos"];
$cenas = @$_POST["cenas"];
$consultaAct = "UPDATE atenciones_esperadas SET 
                                                ATES_cantidad_desayunos = '$desayunos',
                                                ATES_cantidad_almuerzos = '$almuerzos',
                                                ATES_cantidad_cenas = '$cenas',
                                                ATES_usuario = '$usuario' WHERE ATES_id = $idAtencionEsperada";

echo (mysqli_query($conexion,$consultaAct)) 
? json_encode(true) : json_encode(false);                                             