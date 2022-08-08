<?php
session_start();
require_once("../conexion.php");

$idTipoAlimento = @$_POST["idTipoAlimento"];
$idTipoAtencion = @$_POST["idTipoAtencion"];
$cantidad = isset($_POST["cantidad"]) ? $_POST["cantidad"] : 1;
$resTipoAlimento = mysqli_query($conexion,"SELECT * FROM tipo_alimentos WHERE TIAL_id = $idTipoAlimento");
$arrayTipoAlimento = mysqli_fetch_assoc($resTipoAlimento);

$tipoAlimentosAgregados = [
    "id" => $arrayTipoAlimento["TIAL_id"],
    "descripcion" => $arrayTipoAlimento["TIAL_descripcion"],
    "marca" => $arrayTipoAlimento["TIAL_marca"],
    "unidad" => $arrayTipoAlimento["TIAL_unidad"],
    "precio" =>  explode(".",$arrayTipoAlimento["TIAL_precio"])[0],
    "cantidad" => $cantidad,
];
if (isset($_SESSION['sesionTipoAlimentos'])) {
foreach ($_SESSION['sesionTipoAlimentos'] as $k) {
    if ($k["id"] === $idTipoAlimento) {
        echo json_encode([false,'El producto ya fue agregado!']);
        die();
    }
}
}
if ($idTipoAtencion == 1) {
    if (isset($_SESSION['sesionTipoAlimentos'])) {
        if (count(($_SESSION['sesionTipoAlimentos'])) > 0) {
            echo json_encode([false,'No es posible agregar mas de un alimento en ingreso por AJUSTE ']);
            die();
        }
    }
}
$_SESSION['sesionTipoAlimentos'][] = $tipoAlimentosAgregados;

echo json_encode([true,'Agregado!']);
