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