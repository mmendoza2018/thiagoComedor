<?php 
include_once("../conexion.php");
$empresas = mysqli_query($conexion, "SELECT EMPR_razonSocial,EMPR_id FROM empresas WHERE EMPR_estado = 1");
$areas = mysqli_query($conexion, "SELECT AREA_descripcion,AREA_id FROM areas WHERE AREA_estado = 1");
?>
<!-- Modal actualiza proyectos -->
<div class="modal fade" id="modalComensalesAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div>
        <div class="text-end">
          <button type="button" class="btn-close p-2" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <h5 class="modal-title text-center" id="staticBackdropLabel">Editar Proyecto</h5>
      </div>
      <div class="modal-body">
        <form id="formComensalesAct" onsubmit="actualizaComensales(this)">
          <input type="text" name="id" hidden id="idComensalesAct">
          <label>Nombres y Apellidos</label>
          <input name="nombres" data-validate class="form-control form-control-sm" id="nombresComensalesAct" />
          <label>DNI</label>
          <input name="dni" data-validate class="form-control form-control-sm" id="dniComensalesAct" />
          <label>Empresa</label>
          <select class="form-select form-select-sm" data-validate name="empresa" id="empresaComensalesAct">
            <option value="" selected disabled>Seleccione una opción</option>
            <?php foreach ($empresas as $x) : ?>
            <option value="<?php echo $x["EMPR_id"] ?>"><?php echo $x["EMPR_razonSocial"] ?></option>
            <?php endforeach; ?>
          </select>
          <label>Area</label>
          <select class="form-select form-select-sm" data-validate name="area" id="areaComensalesAct">
            <option value="" selected disabled>Seleccione una opción</option>
            <?php foreach ($areas as $x) : ?>
            <option value="<?php echo $x["AREA_id"] ?>"><?php echo $x["AREA_descripcion"] ?></option>
            <?php endforeach; ?>
          </select>
          <label>Estado</label>
          <select class="form-select form-select-sm mb-2" name="estado" id="estadoComensalesAct" data-validate>
            <option value="1">Habilitado</option>
            <option value="0">inhabilitar</option>
          </select>
          <button type="submit" class="btn btn-sm btn-primary float-end mt-1">ACTUALIZAR</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal actualiza atenciones del dia  -->
<div class="modal fade" id="modalActAtencionesDelDia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div>
        <div class="text-end">
          <button type="button" class="btn-close p-2" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <h6 class="modal-title text-center" id="staticBackdropLabel">Actualizar atenciones del día</h6>
      </div>
      <div class="modal-body">
        <form id="formActAtencionesEsperadas" onsubmit="actualizaAtencionesEsperadas(this)">
          <input type="text" name="idAtencionEsperada" hidden id="idAtencionEsperada">
          <label>Empresa</label>
          <input name="empresa" readonly class="form-control form-control-sm" id="descEmpresaAteEspe" />
          <label>Desayunos</label>
          <input name="desayunos" data-validate class="form-control form-control-sm" id="desayunosAteEspe" />
          <label>Almuerzos</label>
          <input name="almuerzos" data-validate class="form-control form-control-sm" id="alumuerzosAteEspe" />
          <label>Cenas</label>
          <input name="cenas" data-validate class="form-control form-control-sm" id="cenasAteEspe" />
          <button type="submit" class="btn btn-sm btn-primary float-end mt-1">ACTUALIZAR</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal agrega atenciones del dia  -->
<div class="modal fade" id="modalAddAtencionesDelDia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div>
        <div class="text-end">
          <button type="button" class="btn-close p-2" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <h6 class="modal-title text-center" id="staticBackdropLabel">Agregar atenciones del día</h6>
      </div>
      <div class="modal-body">
        <form id="formAddAtencionesEsperadas" onsubmit="agregaAtencionesEsperadas(this)">
          <input type="text" name="idEmpresa" hidden id="idEmpresaAteEspeAdd">
          <label>Empresa</label>
          <input name="empresa" readonly class="form-control form-control-sm" id="empresaAteEspeAdd"/>
          <label>Desayunos</label>
          <input name="desayunos" data-validate class="form-control form-control-sm" />
          <label>Almuerzos</label>
          <input name="almuerzos" data-validate class="form-control form-control-sm"/>
          <label>Cenas</label>
          <input name="cenas" data-validate class="form-control form-control-sm" />
          <button type="submit" class="btn btn-sm btn-primary float-end mt-1">AGREGAR</button>
        </form>
      </div>
    </div>
  </div>
</div>