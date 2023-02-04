<?php
require_once "../../conexion.php";
require_once "modales.php";

?>
<div>
  <h5>GESTIÓN DEL PERSONAL</h5>
</div>
<div class="container-fluid bg-white my-2 py-3">
  <!-- /.box-header -->
  <div class="table-responsive">
    <table id="tablaListaPersonal" class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>DNI</th>
          <th>Nombres y Apellidos</th>
          <th>Telefono</th>
          <th>Correo</th>
          <th>Unidad minera</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <?php
      $consulta = "SELECT * FROM personas pe INNER JOIN unidad_minera um ON pe.UNMI_id01 = um.UNMI_id WHERE PER_estado = 1";
      $resPersonal = mysqli_query($conexion, $consulta);
      $contador = 1;
      foreach ($resPersonal as $x) { 
        $estadoTrabajo = $x["PER_estado_trabajo"];
        $htmlEstadoTrabajo = ($estadoTrabajo == 1) 
        ? "<span class='badge bg-success'>Laborando</span>" 
        : "<span class='badge bg-danger'>Retirado</span>";

        $idPersona = $x["PER_id"];?>
        <tr>
          <td><?php echo $contador ?></td>
          <td><?php echo $x["PER_usuario"] ?></td>
          <td><?php echo $x["PER_nombres"] . ' ' . $x["PER_apellidos"]; ?> </td>
          <td><?php echo $x["PER_telefono"]; ?></td>
          <td><?php echo $x["PER_correo"]; ?></td>
          <td><?php echo $x["UNMI_descripcion"]; ?></td>
          <td><?php echo $htmlEstadoTrabajo; ?></td>
          <td>
            <a class="text-decoration-none" href="#"
            onclick="generaPdf('php/generaPDF/fichaPersonal/index.php?id=<?php echo $idPersona ?>', 'Ficha Personal')">
            <i class="fas fa-file-pdf"></i>
            </a>
            |
            <a class="text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#modalActPersonal" onclick="llenarPersonas('<?php echo $x['PER_id']; ?>')">
              <i class="fa fa-edit"></i>
            </a>
  <!--           |
            <a class="text-decoration-none" href="frm-detfamilia.php?id=<?php echo $x["id_persona"]; ?>">
              <i class="fa fa-child"></i>
            </a> -->
          </td>
        </tr>
      <?php $contador++; } ?>
    </table>
  </div>
  <!-- /.box-body -->
</div>
<script>
  $(document).ready(function() {
    $('#tablaListaPersonal').DataTable({
      "info": false,
      "ordering": false,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
      }
    });
  });
  setTimeout(() => {
    $('#smartwizardAct').smartWizard({
      lang: { // Language variables for button
        next: 'Siguiente',
        previous: 'Atras'
      },
      toolbar: {
        extraHtml: '<button class="btn btn-primary" type="button" onclick="actualizaPersonal()">Actualizar</button>' // Extra html to show on toolbar
      },
    });
  }, 1000);
</script>