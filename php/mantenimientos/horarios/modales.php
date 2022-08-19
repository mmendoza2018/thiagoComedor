<!-- Modal actualiza tipo documentos -->
<?php require_once('modales.php');
require_once('../../conexion.php');
$resAlimentos = mysqli_query($conexion, "SELECT * FROM tipo_alimentos");
?>
<div class="modal fade" id="modalHorarioAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Editar Horarios</h5>
      </div>
      <div class="modal-body">
        <form id="formHorariosAct">
          <input type="text" name="HORA_id" hidden id="HORA_id">          
          <label class="mb-1">Hora Inicio</label>
          <input type="time" class="form-control form-control-sm mb-2" data-validate name="HORA_inicio" id="HORA_inicio" step="1" data-validate>
          <label class="mb-1">Hora Final</label>
          <input type="time" class="form-control form-control-sm mb-2" data-validate name="HORA_final" id="HORA_final" step="1">
          <!-- <label class="mb-1">Tipo Alimento</label>
          <input type="text" name="TIAL_id01" class="form-control form-control-sm mb-2" id="TIAL_id01" data-validate> -->
          <label>Estado</label>
          <select class="form-select form-select-sm mb-2" name="HORA_estado" id="HORA_estado" data-validate>
            <option value="1">Habilitado</option>
            <option value="0">Inhabilitar</option>
          </select>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-sm btn-primary" onclick="actualizaHorario()">ACTUALIZAR</button>
      </div>
    </div>
  </div>
</div>
<!-- fin modal -->