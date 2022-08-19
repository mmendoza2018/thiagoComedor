<?php
session_start();
require_once("../conexion.php");
$consulta = "SELECT COME_id,COME_nombres,COME_dni,AREA_descripcion,AREA_id,EMPR_razonSocial,EMPR_id FROM comensales c 
                INNER JOIN areas a ON c.AREA_id01=a.AREA_id
                INNER JOIN empresas e ON c.EMPR_id01=e.EMPR_id
                WHERE  COME_estado=1";

$conComensales = mysqli_query($conexion, $consulta);
?>

<div class="table-responsive">
  <table id="tablaComensales1" class="table table-striped table-sm">
    <thead>
      <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>DNI</th>
        <th>Empresa</th>
        <th>Area</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($conComensales as $x) :
        $data = $x["COME_id"] . "|" . $x["COME_nombres"] . "|" . $x["COME_dni"]. "|" . $x["AREA_id"]. "|" . $x["EMPR_id"] ?>
        <tr>
          <td><?php echo $x["COME_id"] ?></td>
          <td><?php echo $x["COME_nombres"] ?></td>
          <td><?php echo $x["COME_dni"] ?></td>
          <td><?php echo $x["EMPR_razonSocial"] ?></td>
          <td><?php echo $x["AREA_descripcion"] ?></td>
          <td>
            <a href="#" class="text-dark" data-bs-toggle="modal" data-bs-target="#modalComensalesAct" onclick="llenarDatosComensales('<?php echo $data  ?>')"><i class="fas fa-list-ul"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script>
  $(document).ready(function() {
    $('#tablaComensales1').DataTable({
      "info": false,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
      }
    });
  });
</script>