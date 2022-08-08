<?php
session_start();
if (isset($_SESSION['sesionTipoAlimentos'])) {
    unset($_SESSION['sesionTipoAlimentos']);
    echo json_encode([true,"Perfecto"]);
}else{
    echo json_encode([false,"No hay equipos agregados"]);
}
?>