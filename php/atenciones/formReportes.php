<?php 
require_once("../conexion.php");
$resComensales =  mysqli_query($conexion, "SELECT * FROM comensales WHERE COME_estado = 1");
$resEmpresas =  mysqli_query($conexion, "SELECT * FROM empresas WHERE EMPR_estado = 1");
?>

<div class="container-fluid bg-white my-1 py-3">
  <div class="text-center mb-4">
    <h5 class="my-0">REPORTES</h5>
  </div>
  <div class="col-md-4 mx-auto">
  <div class="row">
    <!-- formulario -->
    <div class="col-sm-12" id="formularioAtenciones">
      <form id="formReporteExcel" onsubmit="reporteExcel(this)">
        <label>Comensal</label>
        <select id="dataComensalesAtenciones" name="idComensal" class="form-control select2" >
          <option></option>
          <?php foreach ($resComensales as $x) : ?>
            <option value="<?php echo $x["COME_id"] ?>"><?php echo  $x["COME_nombres"] . " - " . $x["COME_dni"] ?></option>
          <?php endforeach; ?>
        </select>
        <label>Tipo de salida</label>
        <select name="tipoSalida" 
        data-validate 
        class="form-select form-select-sm" 
        id="tipoSalidaExcel" onchange="asignarUrlGeneraExcel(this)">
          <option value="" disabled selected>Selecciona un tipo de salida</option>
          <option value="0">NORMAL</option>
          <option value="1">ADICIONAL</option>
          <option value="2">DELIVERY</option>
          <option value="3">NORMAL Y ADICIONAL</option>
          <option value="4">NORMAL Y DELIVERY</option>
          <option value="5">ADICIONAL Y DELIVERY</option>
          <option value="6">NORMAL, ADICIONAL Y DELIVERY</option>
          <option value="7">OTROS</option>
        </select>
        <label>Empresa</label>
        <select name="idEmpresa" class="form-control select2" >
          <option></option>
          <?php foreach ($resEmpresas as $x) : ?>
            <option value="<?php echo $x["EMPR_id"] ?>"><?php echo  $x["EMPR_razonSocial"] ?></option>
          <?php endforeach; ?>
        </select>
        <label>Fecha inicio</label>
        <input type="date" name="fInicio" onchange="limitarFechaUnMes(this)" data-validate class="form-control form-control-sm">
        <label>Fecha final</label>
        <input type="date" name="fFinal" id="fFinalReporteExcel" data-validate class="form-control form-control-sm">
        <button type="submit" data-url_excel id="buttonGeneraExcel" class="btn btn-primary btn-sm float-end mt-3">GENERAR REPORTE</button>
      </form>
    </div>
  </div>
  </div>
</div>
<script>
    $(document).ready(function() {
    $('.select2').select2({
      placeholder: "Seleccione una opcion",
    });
  });
  $(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  });
</script>