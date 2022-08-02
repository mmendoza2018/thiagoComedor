<?php
include_once("../conexion.php");

$comensales = mysqli_query($conexion, "SELECT * FROM comensales WHERE COME_estado = 1");
$tiposComida = mysqli_query($conexion, "SELECT * FROM tipo_alimentos WHERE TIAL_estado = 1");
$tiposAtencion = mysqli_query($conexion, "SELECT * FROM tipos_atencion WHERE TIAT_estado = 1");


?>
<div class="container-fluid bg-white my-1 py-3">
  <div class="text-center mb-4">
    <h5 class="my-0">REGISTRO ATENCIONES</h5>
  </div>
  <div class="col-md-9 mx-auto">
    <div class="row">
      <!-- formulario -->
      <div class="col-sm-6 pe-5" id="formularioAtenciones">
        <form id="formAddAtenciones">
          <label>Comensal (Registrado)</label>
          <select class="form-select form-select-sm select2Atenciones" onchange="obtenerDatosComensales(this)" name="idComensal">
          <option></option>
          <?php foreach ($comensales as $x) : ?>
              <option value="<?php echo $x["COME_id"] ?>">
              <?php echo  $x["COME_nombres"] . " - " . $x["COME_dni"] ?>
            </option>
          <?php endforeach; ?>
        </select>
          <label>Nombres y apellidos (comensal nuevo)</label>
          <input type="text" class="form-control form-control-sm mb-2" id="ComensalNRegistroDiario" name="comensalNuevo">
          <label>Empresa</label>
          <input type="text" class="form-control form-control-sm mb-2" id="empresaRegistroDiario" readonly>
          <label>Área</label>
          <input type="text" class="form-control form-control-sm mb-2" id="areaRegistroDiario" readonly>
          <?php foreach ($tiposAtencion as $x) : ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" data-validate_atencion onchange="obtenerListaAlimentos(this)" name="tipoAtencion" 
              id="tipoAtencion<?php echo $x["TIAT_id"];  ?>" value="<?php echo $x["TIAT_id"]; ?>">
              <label class="form-check-label" for="tipoAtencion<?php echo $x["TIAT_id"];  ?>">
                ATENCIÓN <?php echo $x["TIAT_descripcion"] ?>
              </label>
            </div>
          <?php endforeach; ?>
          <button type="button" class="btn btn-primary btn-sm float-end mt-3" onclick="agregarAtenciones()">enviar</button>
        </form>
      </div>
      <div class="col-sm-6" id="formularioAtenciones">
        Lista Productos
        <select class="form-select form-select-sm select2Atenciones" id="selectListaAlimentos" onchange="guardarTipoAlimento(this)" name="state">
          <option></option>
        </select>
        <div id="tablaSesionAlimentos"></div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('.select2Atenciones').select2({
      placeholder: "Seleccione una opcion",
    });
  });
  $(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  });
  cargarContenido('php/atenciones/tablaSesionAlimento.php','tablaSesionAlimentos');
</script>