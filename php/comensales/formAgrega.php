<?php
include_once("../conexion.php");
$empresas = mysqli_query($conexion, "SELECT EMPR_razonSocial,EMPR_id FROM empresas WHERE EMPR_estado = 1");
$areas = mysqli_query($conexion, "SELECT AREA_descripcion,AREA_id FROM areas WHERE AREA_estado = 1");
?>
<form id="formAddComensales" onsubmit="agregarComensales(this)">
  <label>Nombres y Apellidos</label>
  <input name="nombres" type="text" data-validate class="form-control form-control-sm" />
  <label>DNI</label>
  <input name="dni" type="text" data-validate class="form-control form-control-sm" />
  <label>Empresa</label>
  <select class="form-select form-select-sm" data-validate name="empresa">
    <option value="" selected disabled>Seleccione una opción</option>
    <?php foreach ($empresas as $x) : ?>
    <option value="<?php echo $x["EMPR_id"] ?>"><?php echo $x["EMPR_razonSocial"] ?></option>
    <?php endforeach; ?>
  </select>
  <label>Cargo</label>
  <select class="form-select form-select-sm" data-validate name="area">
    <option value="" selected disabled>Seleccione una opción</option>
    <?php foreach ($areas as $x) : ?>
    <option value="<?php echo $x["AREA_id"] ?>"><?php echo $x["AREA_descripcion"] ?></option>
    <?php endforeach; ?>
  </select>
  <div class="row mx-0 ps-0 gap-0">
    <div class="col-12 col-md-6 px-0 mx-0">
      <button type="button" class="btn btn-success btn-sm float-end mt-3" data-bs-toggle="modal" data-bs-target="#modalConfirmImportExcel" >IMPORTAR DEL EXCEL</button>
    </div>
    <div class="col-12 col-md-6 px-0 mx-0">
    <button type="submit" class="btn btn-primary btn-sm float-end mt-3">REGISTRAR</button>
    </div>
  </div>
</form>