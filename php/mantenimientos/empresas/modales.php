<!-- Modal actualiza tipo documentos -->
<div class="modal fade" id="modalEmpresasAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Editar Empresa</h5>
      </div>
      <div class="modal-body">
        <form id="formEmpresaAct">
          <input type="text" name="EMPR_id" hidden id="EMPR_id">
          <label> Ruc</label>
          <input type="text" name="EMPR_ruc" class="form-control form-control-sm mb-2" id="EMPR_ruc" data-validate>
          <label> Razon Social</label>
          <input type="text" name="EMPR_razonSocial" class="form-control form-control-sm mb-2" id="EMPR_razonSocial" data-validate>
          <label>Estado</label>
          <select class="form-select form-select-sm mb-2" name="EMPR_estado" id="EMPR_estado" data-validate>
            <option value="1">Habilitado</option>
            <option value="0">Inhabilitar</option>
          </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-sm btn-primary" onclick="actualizaEmpresa()">ACTUALIZAR</button>
      </div>
    </div>
  </div>
</div>
<!-- fin modal -->