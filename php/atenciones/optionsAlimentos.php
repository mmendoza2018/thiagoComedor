<?php
require_once("../conexion.php");
echo $idTipoVenta = @$_POST["idTipoVenta"];
$html = "";
$tipoAlimentos = "SELECT * FROM tipo_alimentos WHERE TIAL_estado=1";

$html .= "<option></option>";
foreach (mysqli_query($conexion, $tipoAlimentos) as $k) {
  $idAlimento = $k["TIAL_id"];
  if ($idTipoVenta == 1) {
    if ($k["TIAL_principal"]==1) {
      $descripcion = $k["TIAL_descripcion"];
      $html .= "<option value='$idAlimento'>$descripcion</option>";
    }
  }else{
    if ($k["TIAL_principal"]==1) {
      $descripcion = $k["TIAL_descripcion"];
      $html .= "<option value='$idAlimento'>$descripcion</option>";
    }else{
      $descripcion = $k["TIAL_descripcion"] . " | " . $k["TIAL_marca"] . " | " . $k["TIAL_unidad"];
      $html .= "<option value='$idAlimento'>$descripcion</option>";
    }
  }
}
echo $html;
