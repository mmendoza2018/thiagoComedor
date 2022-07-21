<?php 
require_once("../conexion.php");
$idComensal = $_POST["idComensal"]; 
$consulta = "SELECT COME_id,AREA_descripcion,EMPR_razonSocial FROM comensales c 
              INNER JOIN areas a ON c.AREA_id01=a.AREA_id
              INNER JOIN empresas e ON c.EMPR_id01=e.EMPR_id
              WHERE  COME_estado=1 AND COME_id = '$idComensal'";

foreach (mysqli_query($conexion,$consulta) as $k) {
  echo json_encode(["empresa" => $k["EMPR_razonSocial"],"area" => $k["AREA_descripcion"]]);
}
?>