<?php
require_once("../../conexion.php");

$resPersonal = mysqli_query($conexion, " SELECT PER_id, PER_nombres,PER_apellidos FROM personas WHERE PER_estado = 1");
foreach ($resPersonal as $x) : ?>
  <option value="<?php echo $x["PER_id"] ?>"><?php echo $x["PER_nombres"] ." ". $x["PER_apellidos"] ?></option>
<?php endforeach ?>