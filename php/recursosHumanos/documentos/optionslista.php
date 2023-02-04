<?php
require_once("../../conexion.php");

$resDocumentos = mysqli_query($conexion, " SELECT TIDO_id, TIDO_descripcion FROM tipo_documentos WHERE TIDO_estado = 1");
foreach ($resDocumentos as $x) : ?>
  <option value="<?php echo $x["TIDO_id"] ?>"><?php echo $x["TIDO_descripcion"] ?></option>
<?php endforeach ?>