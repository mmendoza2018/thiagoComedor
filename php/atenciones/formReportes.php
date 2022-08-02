<?php 
require_once("../conexion.php");
$resComensales =  mysqli_query($conexion, "SELECT * FROM comensales WHERE COME_estado = 1");
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
          <?php foreach ($resComensales as $x) : ?>
            <option value="<?php echo $x["COME_id"] ?>"><?php echo  $x["COME_nombres"] . " - " . $x["COME_dni"] ?></option>
          <?php endforeach; ?>
        </select>
        <label>Fecha inicio</label>
        <input type="date" name="fInicio" class="form-control form-control-sm">
        <label>Fecha final</label>
        <input type="date" name="fFinal" class="form-control form-control-sm">
        <button type="submit" class="btn btn-primary btn-sm float-end mt-3">enviar</button>
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