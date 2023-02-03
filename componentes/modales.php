<?php require_once("../php/conexion.php");
$resPersonal = mysqli_query($conexion, " SELECT * FROM personas");
$restipoDocumentos = mysqli_query($conexion, " SELECT * FROM tipo_documentos WHERE TIDO_estado= 1 ");
?>

<!-- Modal actualiza proyectos -->
<div class="modal fade" id="modalListaDocs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-body">
        <div id="llegaListaDocPer"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" onclick="$('#modalListaDocs').modal('hide')">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal ver documento -->
<div class="modal fade" id="modalVerDocPersonal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div id="llegaPdfPersonal"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" onclick="$('#modalVerDocPersonal').modal('hide')">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal actualiza documento -->
<div class="modal fade" id="modalActDocPersonal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-body">
        <div class="alert alert-warning" role="alert">
          <b>Advertencia</b>
          Al actualizar el documento, se reemplazara y perdera el documento actual. Si desea mantener este documento debe ingresar nuevamente la version actual.
        </div>
        <form id="formActDocPersonal">
          <div class="row">
            <div class="col-md-6">
              <label>Personal</label>
              <input type="hidden" name="idDocumento" id="idDocAct">
              <input type="hidden" id="idPersonaAuxiliar">
              <select name="idPersona" id="idPersonaActDoc" data-validate class="form-select form-select-sm select2">
                <?php foreach ($resPersonal as $x) : ?>
                  <option value="<?php echo $x["PER_id"] ?>"><?php echo $x["PER_nombres"] . " " . $x["PER_apellidos"] ?></option>
                <?php endforeach; ?>
              </select>
              <label>Seleccione tipo Documento</label>
              <select name="idTipoDocumento" id="idTipoDocActDOc" data-validate class="form-select form-select-sm select2">
                <option value=""></option>
                <?php foreach ($restipoDocumentos as $x) : ?>
                  <option value="<?php echo $x["TIDO_id"] ?>"><?php echo $x["TIDO_descripcion"] ?></option>
                <?php endforeach; ?>
              </select>
              <label>Seleccione Documento</label>
              <input type="file" name="documento" class="form-control form-control-sm" readonly="readonly">
              <label>Fecha Inscripcion</label>
              <input type="date" name="fInicio" data-validate id="fInicioDocAct" class="form-control form-control-sm" required="">
              <label>Fecha Vencimiento</label>
              <input type="date" name="fFin" id="fFinDocAct" data-validate class="form-control form-control-sm" required="">
            </div>
            <div class="col-md-6">
              <label>Numero Documento</label>
              <input type="text" class="form-control form-control-sm" name="numero" id="numeroDocAct" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <label>Descripcion Documento</label>
              <input type="text" class="form-control form-control-sm" name="descripcion" id="descripcionDocAct" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <label>Empresa</label>
              <input type="text" class="form-control form-control-sm" name="empresa" id="empresaDocAct" onkeyup="javascript:this.value=this.value.toUpperCase();">
              <label>Observaciones</label>
              <input type="text" class="form-control form-control-sm" id="observacionesDocAct" name="observaciones" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" id="idBtnActDocs" data-tabla onclick="actualizaDocumentoPer(this);">Actualizar</button>
        <button type="button" class="btn btn-sm btn-secondary" onclick="$('#modalActDocPersonal').modal('hide')">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal envio de adjuntos multiples-->
<div class="modal fade" id="modalEnviarAdjuntoMulti" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-red-gyt">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Envio de documentos multiples</h5>
      </div>
      <div class="modal-body">
        <form id="formEnvioAdjuntoMultiple">
          <label>Equipos seleccionados</label>
          <div id="llegadaListaDocumentosMulti" class="row"></div>
          <label>Correo del remitente</label>
          <div class="input-group mb-1">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-at text-dark"></i></span>
            <input type="text" class="form-control form-control-sm" id="correodocsMulti" aria-describedby="basic-addon1" placeholder="Administrador@gyt.com">
          </div>
          <label>Asunto o descripción</label>
          <textarea name="textarea" class="form-control" placeholder="..." id="asuntodocsMulti" rows="3"></textarea>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-sm btn-primary" id="rutaEnvio" onclick="enviarDocEquipoMulti()">Enviar</button>
      </div>
    </div>
  </div>
</div>