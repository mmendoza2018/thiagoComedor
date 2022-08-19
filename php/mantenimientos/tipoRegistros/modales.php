<!-- Modal actualiza tipo documentos -->
<div class="modal fade" id="modalTipoRegistro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Editar Tipo Registro</h5>
      </div>
      <div class="modal-body">
        <form id="formTipoRegistroAct">
          <input type="text" name="TIRE_id" hidden id="TIRE_id">
          <label> Descripción</label>
          <input type="text" name="TIRE_descripcion" class="form-control form-control-sm mb-2" id="TIRE_descripcion" data-validate>
          <label>Estado</label>
          <select class="form-select form-select-sm mb-2" name="TIRE_estado" id="TIRE_estado" data-validate>
            <option value="1">Habilitado</option>
            <option value="0">Inhabilitar</option>
          </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-sm btn-primary" onclick="actualizaTipoRegistro()">ACTUALIZAR</button>
      </div>
    </div>
  </div>
</div>
<!-- fin modal -->