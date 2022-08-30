<?php 
include_once("../conexion.php");
$empresas = mysqli_query($conexion, "SELECT EMPR_razonSocial,EMPR_id FROM empresas WHERE EMPR_estado = 1");
?>

<!-- Modal actualiza tipo documentos -->
<div class="modal fade" id="modalDetalleAdicional" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Detalle </h5>
      </div>
      <div class="modal-body" id="llegaDetalleAdicionalOtros">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">CERRAR</button>
      </div>
    </div>
  </div>
</div>
<!-- fin modal -->

<!-- Modal carga masiva -->
<div class="modal fade" id="modalCargaMasivaSalidas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
    <div>
        <div class="text-end">
          <button type="button" class="btn-close p-2" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <h5 class="modal-title text-center" id="staticBackdropLabel">Importar Excel</h5>
      </div>
      <div class="modal-body">
        <form id="formCargaMasivaSalidas">
          <input type="file" name="archivoExcel" data-validate class="form-control form-control-sm">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" onclick="importarSalidasExcel()">PROCESAR INFORMACIÓN</button>
      </div>
    </div>
  </div>
</div>
<!-- fin modal -->