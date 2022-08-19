  <!-- Modal actualiza tipo documentos -->
  <div class="modal fade" id="modalAlimentoAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Editar Tipo Alimento</h5>
      </div>
      <div class="modal-body">
        <form id="formTipoAlimentoAct">
          <input type="text" name="TIAL_id" hidden id="TIAL_id">
          <label>Descripción</label>
          <input type="text" name="TIAL_descripcion" class="form-control form-control-sm mb-2" id="TIAL_descripcion" data-validate>
          <label>Marca</label>
          <input type="text" name="TIAL_marca" class="form-control form-control-sm mb-2" id="TIAL_marca" data-validate>
          <label>Unidad</label>
          <input type="text" name="TIAL_unidad" class="form-control form-control-sm mb-2" id="TIAL_unidad" data-validate>
          <label>Precio</label>
          <input type="text" name="TIAL_precio" class="form-control form-control-sm mb-2" id="TIAL_precio" data-validate>
          <!-- <label>Tipo Alimento</label>
          <select class="form-select form-select-sm mb-2" name="TIAL_principal" id="TIAL_principal" data-validate>
            <option value="1">NORMAL</option>
            <option value="0">OTROS</option>
          </select> -->
          <label>Estado</label>
          <select class="form-select form-select-sm mb-2" name="TIAL_estado" id="TIAL_estado" data-validate>
            <option value="1">Habilitado</option>
            <option value="0">Inhabilitar</option>
          </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-sm btn-primary" onclick="actualizaTipoAlimento()">ACTUALIZAR</button>
      </div>
    </div>
  </div>
  </div>
  <!-- fin modal -->