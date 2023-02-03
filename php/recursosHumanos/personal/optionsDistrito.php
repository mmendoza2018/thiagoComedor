<?php
include("../../conexion.php");

$idProvincia = $_POST["idSelect"];
$resDistritos = mysqli_query($conexion, "SELECT * FROM distritos WHERE PROVI_id01=$idProvincia");
$optionDistrito="";
$optionDistrito .="<option value=''>-- SELECCIONE --</option>";
foreach ($resDistritos as $k) {
  $idDistrito = $k["DISTRI_id"];
  $descriptionDistrito = $k["DISTRI_descripcion"];
  $optionDistrito .="<option value='$idDistrito'>$descriptionDistrito</option>";
}
echo $optionDistrito;
?>