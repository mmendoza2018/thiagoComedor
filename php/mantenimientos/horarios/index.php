<?php require_once('modales.php');
require_once('../../conexion.php');
$resAlimentos = mysqli_query($conexion, "SELECT * FROM tipo_alimentos WHERE TIAL_principal=1");
?>

<div><h5>HORARIOS</h5></div>
<div class="container-fluid bg-white my-2 py-3">
    <div class="row g-5">
        <div class="col-sm-4">
            <form id="formHorarios">
                <label class="mb-1">Hora Inicio</label>
                <input type="time" class="form-control form-control-sm mb-2" data-validate name="horaInicio" step="1">
                <label class="mb-1">Hora Final</label>
                <input type="time" class="form-control form-control-sm mb-2" data-validate name="horaFinal" step="1">
                <label class="mb-1">Tipo Alimento</label>
                <select class="form-select form-select-sm" data-validate name="tipoAlimento" required="">
                <option value="">-- SELECCIONE --</option>
                <?php foreach ($resAlimentos as $x) : ?>
                <option value="<?php echo $x["TIAL_id"] ?>"><?php echo $x["TIAL_descripcion"] ?></option>
                <?php endforeach; ?>
                </select><br>
                <button class="btn btn-blue-gyt btn-sm float-end"  disabled type="button">AGREGAR</button>
                <!-- onclick="agregarHorario()" -->
            </form>
        </div>
        <div class="col-sm-8">
            <div id="contenedorTablaHorarios"></div>
        </div>
    </div>
</div>

<script>
  cargarContenido('php/mantenimientos/horarios/tabla.php','contenedorTablaHorarios');
</script>