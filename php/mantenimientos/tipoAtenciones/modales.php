<!-- Modal actualiza tipo documentos -->
<div class="modal fade" id="modalTipoAtencionAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Editar Tipo Atencion</h5>
      </div>
      <div class="modal-body">
        <form id="formTipoAtencionAct">
          <input type="text" name="TIAT_id" hidden id="TIAT_id">
          <label> Descripción</label>
          <input type="text" name="TIAT_descripcion" class="form-control form-control-sm mb-2" id="TIAT_descripcion" data-validate>
          <label>Estado</label>
          <select class="form-select form-select-sm mb-2" name="TIAT_estado" id="TIAT_estado" data-validate>
            <option value="1">Habilitado</option>
            <option value="0">Inhabilitar</option>
          </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-sm btn-blue-gyt" onclick="actualizaTipoAtencion()">Actualizar</button>
      </div>
    </div>
  </div>
</div>
<!-- fin modal -->