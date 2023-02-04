<?php
require_once("../../conexion.php");
$resUnidadMinera = mysqli_query($conexion, "SELECT * FROM unidad_minera WHERE UNMI_estado = 1");
$resTipoDoc = mysqli_query($conexion, "SELECT * FROM tipo_documentos WHERE TIDO_estado = 1");
?>
<div class="container-fluid bg-white my-2 py-3" style="height: 70vh;">
  <div class="col-sm-4 mx-auto shadow p-4">
    <h5 class="text-center">Vencimiento de documentos</h5>
    <form id="formReporteDocumentosVencer" onsubmit="reporteExcelDocumentosVencidos(this);">
      <label>Unidad minera</label>
      <select class="form-select form-select-sm" name="unidadMinera">
        <option value="">-- SELECCIONE --</option>
        <?php foreach ($resUnidadMinera as $x) : ?>
          <option value="<?php echo $x["UNMI_id"] ?>"><?php echo $x["UNMI_descripcion"] ?></option>
        <?php endforeach; ?>
      </select>
      <label>Tipo de documento</label>
      <select class="form-select form-select-sm"  name="tipoDocumento">
      <option value="">-- SELECCIONE --</option>
        <?php foreach ($resTipoDoc as $x) : ?>
          <option value="<?php echo $x["TIDO_id"] ?>"><?php echo $x["TIDO_descripcion"] ?></option>
        <?php endforeach; ?>
      </select>
      <label>Fecha vencimiento ( desde )</label>
      <input type="date" class="form-control form-control-sm" data-validate name="fecha1">
      <label>Fecha vencimiento ( hasta )</label>
      <input type="date" class="form-control form-control-sm" data-validate name="fecha2">

      <div class="text-end">
        <button class="btn btn-success btn-sm mt-2 text-light" type="submit">Generar reporte</button>
      </div>
    </form>
  </div>
</div>