<?php
include_once("../../conexion.php");
//include_once("../../calculo_tiempo.php");
$contador = 1;

$consultaDocumento = "SELECT * FROM documentos do 
                      INNER JOIN personas pe ON do.PER_id01 = pe.PER_id
                      INNER JOIN unidad_minera um ON pe.UNMI_id01 = um.UNMI_id
                      LEFT JOIN tipo_documentos td ON do.TIDO_id01 = td.TIDO_id
                      ";

$resListadoDoc = mysqli_query($conexion, $consultaDocumento);

?>
<div>
  <div>
    <h5>ENVIO MASIVO DE DOCUMENTOS</h5>
  </div>
  <div class="container-fluid bg-white my-2 py-3">
    <div class="row justify-content-end mt-0 mb-2">
      <div class="col-sm-4 col-lg-3  col-xs-5">
        <button type="button" class="btn btn-danger btn-sm float-end" onclick="modalEnvioDocumentosMulti()">
          enviar archivos
          <i class="fas fa-envelope-open-text text-light"></i>
        </button>
      </div>
    </div>
    <div class="table-responsive">
      <table id="tablaListaDoc" class="table table-striped">
        <thead>
          <tr>
            <th></th>
            <th>#</th>
            <th>Persona | DNI</th>
            <th>Unidad minera</th>
            <th>Tipo Documento</th>
            <th>Descripcion</th>
            <th>FechaInicio</th>
            <th>FechaFin</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <?php
        foreach ($resListadoDoc as $x) {
          $idDocumento = $x["DOCU_id"]; ?>
          <tr>
            <td>
              <input type="checkbox" onclick="capturarIddocEquipoMultiple(this)" data-check="<?php echo $x["DOCU_id"]; ?>" class="mx-2" data-codigo="<?php echo $x["PER_usuario"]; ?>" data-documento="<?php echo $x["TIDO_descripcion"]; ?>">
            </td>
            <td><?php echo $contador; ?></td>
            <td><?php echo $x["PER_nombres"]. " " .$x["PER_apellidos"]. " | " .$x["PER_usuario"]; ?></td>
            <td><?php echo $x["UNMI_descripcion"] ?></td>
            <td><?php echo $x["TIDO_descripcion"]; ?></td>
            <td><?php echo $x["DOCU_descripcion"]; ?></td>
            <td><?php echo $x["DOCU_fecha_ingreso"]; ?></td>
            <td><?php echo $x["DOCU_fecha_vencimiento"]; ?></td>
            <td class="text-center">
              <a class="link_edit text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalVerDocPersonal" onclick="verDocumentoPersonal('<?php echo $idDocumento ?>')" href="#">
                <i class="fa fa-print"></i>
              </a>
            </td>
          </tr>
        <?php $contador++;
        } ?>
      </table>
    </div>
  </div>
</div>
<script>
  var table = $('#tablaListaDoc').DataTable({
    "info": false,
    "language": {
      "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
    }
  });
  removeDataLSDocMulti();
</script>