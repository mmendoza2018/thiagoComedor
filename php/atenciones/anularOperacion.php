<?php
require_once("../conexion.php");
$idRegistro = $_POST["idRegistro"];
$consulta = "UPDATE registros_alimentacion SET  REAL_estado = 0 WHERE REAL_id='$idRegistro'";

echo (mysqli_query($conexion, $consulta)) ? json_encode(true) : json_encode(false);
mysqli_close($conexion);
