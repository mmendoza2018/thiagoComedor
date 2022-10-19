<?php
session_start();
require_once("../conexion.php");
$consulta = "SELECT * FROM registros_alimentacion ra
                INNER JOIN tipo_alimentos ta ON ra.TIAL_id01=ta.TIAL_id
                INNER JOIN cedes ce ON ra.CEDE_id01=ce.CEDE_id
                INNER JOIN comensales co  ON ra.COME_id01=co.COME_id
                INNER JOIN areas a ON co.AREA_id01=a.AREA_id
                INNER JOIN empresas e ON co.EMPR_id01=e.EMPR_id
                WHERE  REAL_estado=1";

$conComensales = mysqli_query($conexion, $consulta);
?>

<div class="container-fluid bg-white my-1 py-3">
  <div class="text-center mb-4">
    <h5 class="my-0">ATENCIONES NORMALES</h5>
  </div>
<div class="table-responsive">
  <table  class="table table-striped table-sm" id="tablaAtencionesNormales">
    <thead>
      <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>DNI</th>
        <th>Empresa</th>
        <th>Area</th>
        <th>Alimento</th>
        <th>Comedor</th>
        <th>Fecha</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($conComensales as $x) :
        $data = $x["COME_id"] . "|" . $x["COME_nombres"] . "|" . $x["COME_dni"]. "|" . $x["AREA_id"]. "|" . $x["EMPR_id"] ?>
        <tr class="<?php if ($x["REAL_estado"] == 1) echo 'bg-danger-opacity' ?>">
          <td><?php echo $x["REAL_id"] ?></td>
          <td><?php echo $x["COME_nombres"] ?></td>
          <td><?php echo $x["COME_dni"] ?></td>
          <td><?php echo $x["EMPR_razonSocial"] ?></td>
          <td><?php echo $x["AREA_descripcion"] ?></td>
          <td><?php echo $x["TIAL_descripcion"] ?></td>
          <td><?php echo $x["CEDE_descripcion"] ?></td>
          <td><?php echo $x["REAL_fecha"] ?></td>
          <td>
            <?php if($x["REAL_estado"] == 1) { ?>
              <a href="#" data-bs-toggle="modal" data-bs-target="#modalDetalleAdicional" onclick="verDetalleSalidas('<?php echo $idRegistro ?>')">
                <span class="badge bg-danger">Anular</span>
              </a>
            <?php } ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</div>
<script>
  $(document).ready(function() {
    $('#tablaAtencionesNormales').DataTable({
      "info": false,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
      }
    });
  });
</script>