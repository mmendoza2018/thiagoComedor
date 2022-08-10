<?php
session_start();
require_once("../conexion.php");
$consulta = "SELECT * FROM registros_alimentacion ra
                LEFT JOIN tipo_alimentos ta ON ra.TIAL_id01=ta.TIAL_id
                INNER JOIN cedes ce ON ra.CEDE_id01=ce.CEDE_id
                WHERE  REAL_estado=1 AND TIAT_id01 = 3";

$conComensales = mysqli_query($conexion, $consulta);
require("modales.php")
?>
<div class="container-fluid bg-white my-1 py-3">
  <div class="text-center mb-4">
    <h5 class="my-0">ATENCIONES OTROS</h5>
  </div>
  <div class="table-responsive">
    <table id="tablaAtencionesOtros" class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Fecha</th>
          <th>Comedor</th>
          <th>Solicitante</th>
          <th>Detalle</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($conComensales as $x) :
          $idRegistro = $x["REAL_id"]; ?>
          <tr>
            <td><?php echo $x["REAL_id"] ?></td>
            <td><?php echo $x["REAL_fecha"] ?></td>
            <td><?php echo $x["CEDE_descripcion"] ?></td>
            <td><?php echo $x["REAL_solicitante"] ?></td>
            <td>
              <a href="#" data-bs-toggle="modal" data-bs-target="#modalDetalleAdicional" onclick="verDetalleSalidas('<?php echo $idRegistro ?>')">
                <span class="badge bg-primary">Detalle</span>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#tablaAtencionesOtros').DataTable({
      "info": false,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
      }
    });
  });
</script>