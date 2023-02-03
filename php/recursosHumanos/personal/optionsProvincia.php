
<?php
include("../../conexion.php");
$idDepartamento = $_POST["idSelect"];
$resProvincias = mysqli_query($conexion, "SELECT * FROM provincias WHERE DEPA_id01=$idDepartamento");
$optionProvincias = "";
$optionProvincias .="<option value=''>-- SELECCIONE --</option>";
foreach ($resProvincias as $k) {
  $idCity = $k["PROVI_id"];
  $descriptionCity = $k["PROVI_descripcion"];
  $optionProvincias .="<option value='$idCity'>$descriptionCity</option>";
}
echo $optionProvincias;
?>