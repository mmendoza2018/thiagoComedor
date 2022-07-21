<?php
require_once("../conexion.php");
$nombres = $_POST["nombres"];
$dni = $_POST["dni"];
$empresa = $_POST["empresa"];
$area = $_POST["area"];

$consulta = "INSERT INTO comensales (COME_nombres,	
                                  COME_dni,	
                                  EMPR_id01,	
                                  AREA_id01)
             VALUES ('$nombres','$dni','$empresa','$area')";

echo (mysqli_query($conexion, $consulta)) ? json_encode(true) : json_encode(false);
mysqli_close($conexion);
