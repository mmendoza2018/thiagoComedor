<?php
require_once("../../conexion.php");
$resUnidadMinera = mysqli_query($conexion, "SELECT * FROM unidad_minera WHERE UNMI_estado = 1");

?>
<div class="container-fluid bg-white my-2 py-3" style="height: 50vh;">
  <div class="col-sm-4 mx-auto shadow p-4">
    <h5 class="text-center">Reporte trabajadores</h5>
    <form id="formReporteTrabajadores" onsubmit="reporteExcelTrabajadores(this);">
      <label>Estado del trabajador</label>
      <select class="form-select form-select-sm" name="estadoTrabajador">
        <option value="" selected="" >-- SELECCIONE --</option>
        <option value="Activos">Activos</option>
        <option value="Retirados">Retirados</option>
      </select>
      <label>Unidad minera</label>
      <select class="form-select form-select-sm" name="unidadMinera">
        <option value="">-- SELECCIONE --</option>
        <?php foreach ($resUnidadMinera as $x) : ?>
          <option value="<?php echo $x["UNMI_id"] ?>"><?php echo $x["UNMI_descripcion"] ?></option>
        <?php endforeach; ?>
      </select>
      <div class="text-end">
        <button class="btn btn-success btn-sm mt-2 text-light" type="submit">Generar reporte</button>
      </div>
    </form>
  </div>
</div>