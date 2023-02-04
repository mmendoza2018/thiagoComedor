<div class="modal fade" id="modalUnidadMinera" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Editar unidad minera</h5>
      </div>
      <div class="modal-body">
        <form id="formUnidadMineraAct">
          <input type="text" name="idAct" hidden="" id="idUnMiAct">
          <label> Descripción</label>
          <input type="text" name="descripcionAct" class="form-control form-control-sm mb-2" id="descripcionUnMiAct" data-validate="">
          <label>Estado</label>
          <select class="form-select form-select-sm mb-2" name="estadoAct" data-validate="">
            <option value="1">Habilitado</option>
            <option value="0">inhabilitar</option>
          </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-sm btn-primary" onclick="actualizaUnidadMinera()">Actualizar</button>
      </div>
    </div>
  </div>
</div>