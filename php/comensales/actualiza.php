<?php
require_once("../conexion.php");
$id = $_POST["id"];
$nombres = $_POST["nombres"];
$dni = $_POST["dni"];
$empresa = $_POST["empresa"];
$area = $_POST["area"];

$consulta = "UPDATE comensales SET  COME_nombres ='$nombres',	
                                    COME_dni ='$dni',	
                                    EMPR_id01 ='$empresa',	
                                    AREA_id01 ='$area' WHERE COME_id='$id'";

echo (mysqli_query($conexion, $consulta)) ? json_encode(true) : json_encode(false);
mysqli_close($conexion);
