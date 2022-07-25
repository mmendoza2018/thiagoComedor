<?php
session_start();
require_once("../conexion.php");

$idTipoAlimento = @$_POST["idTipoAlimento"];
$resTipoAlimento = mysqli_query($conexion,"SELECT * FROM tipo_alimentos WHERE TIAL_id = $idTipoAlimento");
$arrayTipoAlimento = mysqli_fetch_assoc($resTipoAlimento);

$tipoAlimentosAgregados = [
    "id" => $arrayTipoAlimento["TIAL_id"],
    "descripcion" => $arrayTipoAlimento["TIAL_descripcion"],
    "marca" => $arrayTipoAlimento["TIAL_marca"],
    "unidad" => $arrayTipoAlimento["TIAL_unidad"],
    "precio" =>  explode(".",$arrayTipoAlimento["TIAL_precio"])[0],
    "cantidad" => 1,
];
$_SESSION['sesionTipoAlimentos'][] = $tipoAlimentosAgregados;

echo json_encode(true);
