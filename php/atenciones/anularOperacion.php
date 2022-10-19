<?php
require_once("../conexion.php");
$id = $_POST["id"];

$consulta = "UPDATE registros_alimentacion SET  REAL_estado = 0 WHERE COME_id='$id'";

echo (mysqli_query($conexion, $consulta)) ? json_encode(true) : json_encode(false);
mysqli_close($conexion);
