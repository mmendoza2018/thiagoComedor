<!-- Modal actualiza tipo documentos -->
<div class="modal fade" id="modalCargosAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Editar Cargos</h5>
      </div>
      <div class="modal-body">
        <form id="formCargosAct">
          <input type="text" name="AREA_id" hidden id="AREA_id">
          <label> Descripción</label>
          <input type="text" name="AREA_descripcion" class="form-control form-control-sm mb-2" id="AREA_descripcion" data-validate>
          <label>Estado</label>
          <select class="form-select form-select-sm mb-2" name="AREA_estado" id="AREA_estado" data-validate>
            <option value="1">Habilitado</option>
            <option value="0">Inhabilitar</option>
          </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-sm btn-primary" onclick="actualizaCargos()">ACTUALIZAR</button>
      </div>
    </div>
  </div>
</div>
<!-- fin modal -->