<?php
        $conexion = new mysqli("localhost:3310", "root","","thiago");
        #$conexion = new mysqli("localhost", "sgthiago_administrador","administradorThiago2023","sgthiago_sistema");
        if ($conexion->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
        }
        mysqli_set_charset($conexion, "utf8");
?>