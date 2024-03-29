<?php
require_once "../../conexion.php";

$consulta = "SELECT * FROM personas pe INNER JOIN unidad_minera um ON pe.UNMI_id01 = um.UNMI_id AND PER_estado = 1";
$resListaPersonas = mysqli_query($conexion, $consulta);
$contador = 1;
?>
<div>
  <h5>GESTION DE LOS DOCUMENTOS</h5>
</div>
<div class="container-fluid bg-white my-2 py-3">
  <div class="table-responsive">
    <table id="tablaListaPersonalDocs" class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>DNI</th>
          <th>Nombres y Apellidos</th>
          <th>Telefono</th>
          <th>Unidad minera</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <?php foreach ($resListaPersonas as $x) {
        $idPersona = $x["PER_id"]; ?>
        <tr>
          <td><?php echo $contador; ?></td>
          <td><?php echo $x["PER_usuario"] ?></td>
          <td><?php echo $x["PER_nombres"].' '. $x["PER_apellidos"]; ?></td>
          <td><?php echo $x["PER_telefono"]; ?></td>
          <td><?php echo $x["UNMI_descripcion"]; ?></td>  
          <td class="text-center">
            <a class="link_delete text-decoration-none" 
            onclick="generaPdf('php/generaPDF/fichaDocPersonal/index.php?id=<?php echo $idPersona ?>', 'Documentos')">
              <i class="far fa-file-pdf"></i>
            </a>
            |
            <a class="link_delete text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#modalListaDocs" onclick="obtenerListaDocsPer('<?php echo $idPersona ?>')">
              <i class="fas fa-list"></i>
            </a>
          </td>
        </tr>
      <?php $contador++;  } ?>
    </table>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#tablaListaPersonalDocs').DataTable({
      "info": false,
      "ordering": false,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
      }
    });
  });
</script>