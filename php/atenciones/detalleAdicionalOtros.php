<?php 
require_once("../conexion.php");
$idRegistroAlimentacion = @$_POST["idRegistroAlimentacion"];

$consulta = "SELECT DESA_id, REAL_fecha,CEDE_descripcion, TIAL_descripcion, DESA_precio, DESA_cantidad, DESA_total
  FROM detalle_salidas ds 
  INNER JOIN tipo_alimentos tal ON ds.TIAL_id01 = tal.TIAL_id
  INNER JOIN registros_alimentacion ra ON ds.REAL_id01 = ra.REAL_id
  INNER JOIN tipos_atencion tat ON ra.TIAT_id01 = tat.TIAT_id
  INNER JOIN cedes ce ON ra.CEDE_id01 = ce.CEDE_id
  WHERE REAL_id01=$idRegistroAlimentacion";

  $resAdiconal = mysqli_query($conexion,$consulta);
?>
<div class="table-responsive">
  <table id="tabla_lista_personas" class="table table-striped table-sm">
    <thead>
      <tr>
        <th>#</th>
        <th>Fecha</th>
        <th>Comedor</th>
        <th>Descripcion</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($resAdiconal as $x) : ?>
        <tr>
          <td><?php echo $x["DESA_id"] ?></td>
          <td><?php echo $x["REAL_fecha"] ?></td>
          <td><?php echo $x["CEDE_descripcion"] ?></td>
          <td><?php echo $x["TIAL_descripcion"] ?></td>
          <td><?php echo $x["DESA_precio"] ?></td>
          <td><?php echo $x["DESA_cantidad"] ?></td>
          <td><?php echo $x["DESA_total"] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>