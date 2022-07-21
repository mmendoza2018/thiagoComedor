<?php
include_once("../conexion.php");
$comensales = mysqli_query($conexion, "SELECT * FROM comensales WHERE COME_estado = 1");
$tiposComida = mysqli_query($conexion, "SELECT * FROM tipos_alimentacion WHERE TIAL_estado = 1");
?>
<form id="formAddAtenciones" onsubmit="agregarAtenciones(this)">
  <label>Comensal</label>
  <input type="text" id="comensalRegistroDiario" list="dataComensalesAtenciones" autocomplete="off" class="form-control form-control-sm mb-2 dataComensalesAtenciones" data-validate>
  <datalist id="dataComensalesAtenciones">
  <?php foreach ($comensales as $x) : ?>
    <option data-value="<?php echo $x["COME_id"] ?>"><?php echo  $x["COME_nombres"] . " - " . $x["COME_dni"] ?></option>
  <?php endforeach;?>
  </datalist>
  <label>Empresa</label>
  <input type="text" class="form-control form-control-sm mb-2" id="empresaRegistroDiario" readonly data-validate name="empresa">
  <label>Área</label>
  <input type="text" class="form-control form-control-sm mb-2" id="areaRegistroDiario" readonly data-validate name="cargo">
  <label>Tipo comida</label>
  <select class="form-select form-select-sm" data-validate name="tipoComida">
    <option value="" selected disabled>Seleccione una opción</option>
    <?php foreach ($tiposComida as $x) : ?>
    <option value="<?php echo $x["TIAL_id"] ?>"><?php echo $x["TIAL_descripcion"] ?></option>
    <?php endforeach; ?>
  </select>

  <button type="submit" class="btn btn-primary btn-sm float-end mt-3">enviar</button>
</form>