<?php 
session_start();
require_once("../conexion.php");
date_default_timezone_set("America/Lima");
$usuario = $_SESSION['datos_trabajador'][0]["nombres"];
$fechaReferencia = @$_POST["fechaReferencia"];
$idEmpresa = @$_POST["idEmpresa"];
$desayunos = @$_POST["desayunos"];
$almuerzos = @$_POST["almuerzos"];
$cenas = @$_POST["cenas"];

$consultaAdd = "INSERT INTO atenciones_esperadas (
                              EMPR_id01,
                              ATES_cantidad_desayunos,
                              ATES_cantidad_almuerzos,
                              ATES_cantidad_cenas,
                              ATES_fecha,
                              ATES_usuario
                            ) 
                    VALUES  ( 
                              $idEmpresa, 
                              $desayunos,
                              $almuerzos,
                              $cenas,
                              '$fechaReferencia',
                              '$usuario'
                            )";
echo (mysqli_query($conexion,$consultaAdd)) ? json_encode(true) :json_encode(false);

?>