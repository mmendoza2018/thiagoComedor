<?php
session_start();
require_once("../conexion.php");
$idCedeSesion = $_SESSION['datos_trabajador'][0]["cede"];
$idComensal = $_POST["idComensal"];
$tipoComida = $_POST["tipoComida"];

$consulta = "INSERT INTO registros_alimentacion   (COME_id01,	
                                                  CEDE_id01,	
                                                  TIAL_id01)
             VALUES ('$idComensal','$idCedeSesion','$tipoComida')";

echo (mysqli_query($conexion, $consulta)) ? json_encode(true) : json_encode(false);
mysqli_close($conexion);
