<?php
require_once('../../conexion.php');
$resPersonal = mysqli_query($conexion, "SELECT * FROM personas WHERE PER_estado = 1");
$resTipoDocs = mysqli_query($conexion, " SELECT * FROM tipo_documentos WHERE TIDO_estado = 1 ");
?>
<div>
  <h5>AGREGAR DOCUMENTOS</h5>
</div>
<div class="container-fluid bg-white my-2 py-3">
  <div class="col-md-7 mx-auto">
    <form id="formAddDocumentoPer" onsubmit="agregarDocumentoPersonal(this)">
      <div class="row">
        <div class="col-md-6">
          <label>Personal</label>
          <select name="idPersona" data-validate class="form-control select2">
            <option></option>
            <?php foreach ($resPersonal as $x) : ?>
              <option value="<?php echo $x["PER_id"] ?>">
                <?php echo $x["PER_nombres"] . " " . $x["PER_apellidos"] ." | ". $x["PER_usuario"] ?>
              </option>
            <?php endforeach; ?>
          </select>
          <label>Seleccione Documento</label>
          <select class="form-control select2" data-validate name="idDocumento" required="">
          <option ></option>
            <?php foreach ($resTipoDocs as $x) : ?>
              <option value="<?php echo $x["TIDO_id"] ?>"><?php echo $x["TIDO_descripcion"] ?></option>
            <?php endforeach; ?>
          </select>
          <label>Fecha Inscripcion</label>
            <input type="date" name="fechaInicio" class="form-control form-control-sm" data-validate data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" required="">
          <label>Fecha Vencimiento</label>
            <input type="date" name="fechaFin" class="form-control form-control-sm" data-validate data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" required="">
        </div>
        <div class="col-md-6">
          <label>Numero Documento</label>
          <input type="text" class="form-control form-control-sm" data-validate name="numerodoc" placeholder="47854749" onkeyup="javascript:this.value=this.value.toUpperCase();">
          <label>Descripcion Documento</label>
          <input type="text" class="form-control form-control-sm" data-validate name="descripcion" placeholder="A4" onkeyup="javascript:this.value=this.value.toUpperCase();">
          <label>Empresa</label>
          <input type="text" class="form-control form-control-sm" data-validate name="empresa" placeholder="PACIFICO SEGUROS" onkeyup="javascript:this.value=this.value.toUpperCase();">
          <label>Observaciones</label>
          <input type="text" class="form-control form-control-sm" name="observacion" placeholder="DOCUMENTO VALIDO POR 90 DIAS" onkeyup="javascript:this.value=this.value.toUpperCase();">
        </div>
        <div class="col-md-6">
          <label>Carga Documento</label>
          <input class="form-control form-control-sm" data-validate name="adjunto" type="file" id="adjunto" required="">
        </div>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-sm btn-primary">REGISTRAR</button>
      </div>
      <br>
    </form>
  </div>
</div>
<script>
  $(document).ready(function() {
    $(".select2").select2({
      placeholder: "Seleccione una opcion",
    });
  });
  $(document).on("select2:open", () => {
    document.querySelector(".select2-search__field").focus();
  });
</script>