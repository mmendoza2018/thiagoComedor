<?php
include_once("../../conexion.php");
//include_once("../../calculo_tiempo.php");
$whereConsulta = "";
$idPersona = @$_POST["idPersona"];
$contador = 1;

$consultaPersona = "SELECT * FROM personas pe 
                    INNER JOIN unidad_minera um ON pe.UNMI_id01 = um.UNMI_id WHERE PER_id = $idPersona ";
$consultaDocumento = "SELECT * FROM documentos do INNER JOIN personas pe ON do.PER_id01 = pe.PER_id
            LEFT JOIN tipo_documentos td ON do.TIDO_id01 = td.TIDO_id
WHERE pe.PER_id=$idPersona";

$resListadoDoc = mysqli_query($conexion, $consultaDocumento);
$resListaPersona = mysqli_query($conexion, $consultaPersona);
$arrayDatosPersona = mysqli_fetch_assoc($resListaPersona);

?>
<div>
  <div class="col-sm-12 col-md-10 col-lg-9  mx-auto">
  <div class="row">
    <div class="col-sm-6">
      <table class="table table-sm">
        <tbody>
          <tr>
            <td class="fw-bold">DNI</td>
            <td><?php echo $arrayDatosPersona["PER_usuario"] ?></td>
          </tr>
          <tr>
            <td class="fw-bold">Nombres y apellidos</td>
            <td><?php echo $arrayDatosPersona["PER_nombres"] .' '.$arrayDatosPersona["PER_apellidos"]; ?></td>
          </tr>
          <tr>
            <td class="fw-bold">Unidad minera</td>
            <td><?php echo $arrayDatosPersona["UNMI_descripcion"] ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-sm-6">
    <table class="table table-sm">
        <tbody>
          <tr>
            <td class="fw-bold">Correo</td>
            <td><?php echo $arrayDatosPersona["PER_correo"] ?></td>
          </tr>
          <tr>
            <td class="fw-bold">Teléfono</td>
            <td><?php echo $arrayDatosPersona["PER_telefono"] ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  </div>
  <div class="container-fluid bg-white my-2 py-3">
    <div class="table-responsive">
      <table id="tablaListaDoc" class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th># documento</th>
            <th>Tipo Documento</th>
            <th>Descripcion</th>
            <th>FechaInicio</th>
            <th>FechaFin</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <?php
        foreach ($resListadoDoc as $x) {
          $idDocumento = $x["DOCU_id"];
          $data = $x["DOCU_id"] ."|".$x["PER_id"] ."|".$x["TIDO_id"] ."|".$x["DOCU_fecha_ingreso"] ."|".$x["DOCU_fecha_vencimiento"] ."|".$x["DOCU_numero"]."|".$x["DOCU_descripcion"]."|".$x["DOCU_empresa"]."|".$x["DOCU_observacion"]."|".$idPersona;
          ?>
          <tr>
            <td><?php echo $contador; ?></td>
            <td><?php echo $x["DOCU_numero"]; ?></td>
            <td><?php echo $x["TIDO_descripcion"]; ?></td>
            <td><?php echo $x["DOCU_descripcion"]; ?></td>
            <td><?php echo $x["DOCU_fecha_ingreso"]; ?></td>
            <td><?php echo $x["DOCU_fecha_vencimiento"]; ?></td>
            <td class="text-center">
              <a class="link_edit text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalActDocPersonal"
              onclick="llenarDocumentosAct('<?php echo $data ?>',false)" href="#">
                <i class="fa fa-edit"></i>
              </a>
              |
              <a class="link_edit text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalVerDocPersonal"  onclick="verDocumentoPersonal('<?php echo $idDocumento ?>')" href="#">
                <i class="fa fa-print"></i>
              </a>
            </td>
          </tr>
        <?php $contador++; } ?>
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
 
</script>