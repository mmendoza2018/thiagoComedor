
<?php
require("../../conexion.php");
$idDocumento = $_POST['idDocumento'];
$identificadorDoc = "";
$traerDocumento = "SELECT DOCU_nombre FROM documentos WHERE DOCU_id='$idDocumento'";
$resTraerDocumento = mysqli_query($conexion, $traerDocumento);

foreach ($resTraerDocumento as $x) {
  $nombreDocumento = $x["DOCU_nombre"];
}

$ubicacionArchivo = "archivos/" . $nombreDocumento;
if (file_exists("../../../" . $ubicacionArchivo)) {
  echo  "<object data=\"$ubicacionArchivo\" type=\"application/pdf\"  height=\"500\" class=\" w-100\"/>";
} else {
  echo "<div class=\"card bg-danger text-white\">
    <div class=\"card-body\">El archivo no fue ubicado, es posible que haya ocurrido un error al guardar o se haya eliminado.</div>
  </div>";
}

?>