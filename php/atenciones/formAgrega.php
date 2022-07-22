<?php
include_once("../conexion.php");

$comensales = mysqli_query($conexion, "SELECT * FROM comensales WHERE COME_estado = 1");
$tiposComida = mysqli_query($conexion, "SELECT * FROM tipo_alimentos WHERE TIAL_estado = 1");

?>
<link rel="stylesheet" href="assets/plugins/select2/dist/css/select2.min.css">
<script src="assets/plugins/select2/dist/js/select2.min.js"></script>
<div class="container-fluid bg-white my-1 py-3">
  <div class="text-center mb-4">
    <h5 class="my-0">REGISTRO ATENCIONES</h5>
  </div>
  <div class="col-md-9 mx-auto">
    <div class="row">
      <!-- formulario -->
      <div class="col-sm-6" id="formularioAtenciones">
        <form id="formAddAtenciones" onsubmit="agregarAtenciones(this)">
          <label>Comensal (Registrado)</label>
          <select class="form-select form-select-sm select2Atenciones" onchange="obtenerDatosComensales(this)" name="state">
          <option></option>
          <?php foreach ($comensales as $x) : ?>
              <option value="<?php echo $x["COME_id"] ?>">
              <?php echo  $x["COME_nombres"] . " - " . $x["COME_dni"] ?>
            </option>
          <?php endforeach; ?>
        </select>
          <label>Comensal nuevo</label>
          <input type="text" class="form-control form-control-sm mb-2" id="ComensalNRegistroDiario" readonly data-validate name="empresa">
          <label>Empresa</label>
          <input type="text" class="form-control form-control-sm mb-2" id="empresaRegistroDiario" readonly data-validate name="empresa">
          <label>Área</label>
          <input type="text" class="form-control form-control-sm mb-2" id="areaRegistroDiario" readonly data-validate name="cargo">
          <button type="submit" class="btn btn-primary btn-sm float-end mt-3">enviar</button>
        </form>
      </div>
      <div class="col-sm-6" id="formularioAtenciones">
        Lista Productos
        <select class="form-select form-select-sm select2Atenciones" onchange="guardarTipoAlimento(this)" name="state">
          <option></option>
          <option value="" selected disabled>Seleccione una opción</option>
            <?php foreach ($tiposComida as $x) : ?>
              <option value="<?php echo $x["TIAL_id"] ?>"><?php echo $x["TIAL_descripcion"] ?></option>
            <?php endforeach; ?>
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