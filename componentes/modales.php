<?php  
session_start();
require_once("../php/conexion.php");
require_once("../php/calculo_tiempo.php");
$equiposAct = "SELECT EQU_codigo,FAM_descripcion,FAM_id,EQU_placa,EQU_serie FROM equipos e INNER JOIN familias fa ON  fa.FAM_id = e.FAM_id01 WHERE EQU_estado=1";
$proyectos = mysqli_query($conexion,"SELECT PROY_id,PROY_descripcion FROM proyectos WHERE PROY_estado!='CIERRE Y FINALIZACION'");
$famEquipos = mysqli_query($conexion,"SELECT * FROM familias WHERE FAM_estado=1");
$conceptoOrden = mysqli_query($conexion,"SELECT * FROM concepto_orden WHERE COOR_estado=1");
$centroCosto = mysqli_query($conexion,"SELECT * FROM centros_costo WHERE CECO_estado = 1");
$empresas = mysqli_query($conexion,"SELECT * FROM empresas WHERE EMP_estado = 1");
$gerentes = mysqli_query($conexion,"SELECT * FROM personas p INNER JOIN roles_persona rp ON p.PER_id=rp.PER_id01 WHERE ROL_id01= 2");

?>

<!-- Modal actualiza proyectos -->
<div class="modal fade" id="modalProyectoAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Editar Proyecto</h5>
      </div>
      <div class="modal-body">
        <form id="formProyectoAct">
            <input type="text" name="idAct" hidden id="idProyAct">
            <label> Descripción</label>
            <input type="text" name="descripcionAct" class="form-control form-control-sm mb-2" id="descripcionProyAct" data-validate>
            <select class="form-select form-select-sm mb-2" name="estadoAct" id="estadoProyAct" data-validate>
                <option value="1">Habilitado</option>
                <option value="0">inhabilitar</option>
            </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-sm btn-blue-gyt" onclick="actualizaProyecto()">ACTUALIZAR</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal actualiza clientes -->
<div class="modal fade" id="modalClienteAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Editar Cliente</h5>
      </div>
      <div class="modal-body">
        <form id="formClienteAct">
            <input type="text" name="idAct" hidden id="idCliAct">
            <label> RUC</label>
            <input type="text" name="rucAct" class="form-control form-control-sm mb-2" id="rucCliAct" data-validate>
            <label> Razon social</label>
            <input type="text" name="razonSocialAct" class="form-control form-control-sm mb-2" id="razonSocialCliAct" data-validate>
            <select class="form-select form-select-sm mb-2" name="estadoAct" id="estadoCliAct" data-validate>
                <option value="1">Habilitado</option>
                <option value="0">inhabilitar</option>
            </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-sm btn-blue-gyt" onclick="actualizaCliente()">ACTUALIZAR</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal alerta documentos equipos -->
<div class="modal fade" id="modaAlertaDocumentos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-red-gyt">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Alerta de documentos</h5>
      </div>
      <div class="modal-body">
        <form id="formEnvioAdjuntos">
        <div class="table-responsive">
    <table id="tabla_propietario" class="table table-striped">
        <thead >
            <tr>
                <th>Codigo Equipo</th>
                <th>Tipo documento</th>
                <th>Descripción</th>
                <th>F. ingreso</th>
                <th>F. vencimiento</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $classCircle="";
            foreach ($docEquipos as $x) : 
             $datosDocEquipo = $x["DOEQ_id"]."|".$x["EQU_codigo"]."|".$x["DOEQ_descripcion"]."|".$x["DOEQ_vencimiento"]."|".$x["TIDO_estado"];
             $classCircle = calculoFechaDocumentos(new DateTime($x["DOEQ_vencimiento"]),$regular,$malo);
             if ($classCircle=="text-success") continue;  ?> 
                <tr>
                    <td><?php echo $x["EQU_codigo"] ?> </td>
                    <td><?php echo $x["TIDO_descripcion"] ?></td>
                    <td><?php echo $x["DOEQ_descripcion"] ?></td>
                    <td><?php echo $x["DOEQ_ingreso"] ?></td>
                    <td>
                        <?php if ($x["DOEQ_vencimiento"]=="0000-00-00"){
                            echo "";
                        }else{ ?>
                            <i class="fas fa-circle <?php echo $classCircle ?>"></i>
                        <?php echo $x["DOEQ_vencimiento"]; } ?> 
                  </td>
                    <td class="text-center"><a href="#"  data-bs-toggle="modal" data-bs-target="#modalDocEquipo" onclick="verDocEquipo('<?php echo $x['DOEQ_id'] ?>')"><i class="fas fa-file-pdf text-dark"></i></a>
                    <a href="#"  data-bs-toggle="modal" data-bs-target="#modalDocEquipoAct" onclick="llenarDatosDocEquipo('<?php echo $datosDocEquipo ?>')"><i class="fas fa-edit text-dark"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal lista de ordenes -->
<div class="modal fade" id="modalListadoOrden" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-body" id="llegaListadoOrdenes">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal actualiza detalle ordenes -->
<div class="modal fade" id="modalActDetalleOrden" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-body" id="llegaListadoDetOrdenesAct">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal lista detalle ordenes -->
<div class="modal fade" id="modalListadoDetOrden" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-body" id="llegaListadoDetOrdenes"> 
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!--inicio de transaccion -->
<div class="modal" id="modalInicioTransaccion" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
    <div class="modal-content">
      <div class="modal-body"> 
        <form id="formInicioTransaccion">
          <div class="text-center">
            <h4 class="text-secondary mb-3">¿Esta seguro de iniciar transacción?</h4>
          </div>
        <label for="finOP"># de Transaccion</label>
        <input type="hidden" id="idPersonaTransaccion" name="idPersona">
        <input type="hidden" id="idOrdenTransaccion" name="idOrden">
        <input type="text" id="finOP" placeholder="Ingresa el numero de transacción" data-validate name="numTransaccion" class="form-control">
        <label for="finOP">Fecha final</label>
        <input type="date" data-validate name="fechaFinal" class="form-control">
        <div class="text-center my-3">
          <button class="btn text-light me-3" type="button" style="background-color: #3085d6;" onclick="envioInicioTransaccion()">Enviar</button>
          <button class="btn text-light" type="button" style="background-color: #d33;" data-bs-dismiss="modal">cancelar</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- alerta finalizar OP -->
<div class="modal" id="modalAlertaFinOP" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
    <div class="modal-content">
      <div class="modal-body"> 
        <form id="formFinalizacionOrden">
        <h3 class="text-secondary mb-3">¿Estas seguro de finalizar esta OP?</h3>
        <label for="finOP"># de documento</label>
        <input type="hidden" id="idOrdenFinalizacion" name="idOrden">
        <input type="hidden" id="idPersonaFinalizacion" name="idPersona">
        <input type="text" id="finOP" placeholder="Ingresa el numero de documento" data-validate="" name="docFinalizacion" class="form-control">
        <div class="text-center my-3">
          <button class="btn text-light me-3" type="button" style="background-color: #3085d6;" onclick="finalizarOrden()">Enviar</button>
          <button class="btn text-light" type="button" style="background-color: #d33;" data-bs-dismiss="modal">cancelar</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar detalle orden -->
<div class="modal fade" id="modalAddDetalleOrden" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Agregar orden de pedido</h5>
      </div>
      <div class="modal-body">
        <form id="formAgregaTipoOrden">
          <label>Proyecto</label>
          <input type="hidden" name="idOrden" id="idOrdenAdd">
          <input type="text" readonly class="form-control form-control-sm mb-2" id="descOrdenAdd" data-validate >
          <label>Concepto</label>
          <select class="form-select form-select-sm" data-validate name="concepto" id="descPropietarioAct2">
              <option value=""  selected disabled>Seleccione una opción</option>
              <?php foreach ($conceptoOrden as $x) : ?>
              <option value="<?php echo $x["COOR_id"] ?>"><?php echo $x["COOR_descripcion"] ?></option>
              <?php endforeach ?>
          </select>
          <label>Monto</label>
          <input type="number" name="monto"  class="form-control form-control-sm mb-2" id="equipoImgEqAct" data-validate >
          <label>Observaciones</label>
          <input type="text" name="observacion"  class="form-control form-control-sm mb-2" id="equipoImgEqAct" data-validate >
          <label>Operación</label>
          <select class="form-select form-select-sm mb-2" name="operacion" data-validate>
          <option value="" disabled>Seleccione una opción</option>
          <?php 
          if ($_SESSION["datos_trabajador"][0]["rol"]==6) { ?>
            <option value="DEBE">DEBE</option> 
          <?php }   
          if ($_SESSION["datos_trabajador"][0]["rol"]==3) { ?>
            <option value="HABER">HABER</option>
            <option value="REINTEGRO">REINTEGRO</option>
            <option value="DEVOLUCIÓN">DEVOLUCIÓN</option>
          <?php } ?>    
          </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-sm btn-blue-gyt" onclick="agregaTipoOrden()">REGISTRAR</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar ordenes -->
<div class="modal fade" id="modalAddOrden" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Agregar orden de pedido</h5>
      </div>
      <div class="modal-body">
        <form id="formAgregaOrden">
          <div class="row">
            <div class="col-md-6">
            <label>Persona</label>
              <input type="hidden" name="idPersona" id="idPersona">
              <input type="text" readonly class="form-control form-control-sm mb-2" id="descPersonaAdd" data-validate >
            </div>
            <div class="col-md-6">
            <label>Motivo</label>
            <input type="text" name="motivo"  class="form-control form-control-sm mb-2" id="equipoImgEqAct" data-validate >
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
            <label>Centro de costo</label>
          <input type="text" list="centroCostoAddOp" class="form-control form-control-sm mb-2 centroCostoAddOp" data-validate >
            <datalist id="centroCostoAddOp">
            <?php
            foreach ($centroCosto as $x) : ?>
                <option data-value="<?php echo $x["CECO_id"] ?>"><?php echo  $x["CECO_descripcion"] ?></option>
            <?php endforeach;?>
            </datalist>
            </div>
            <div class="col-md-6">
              <label>Moneda</label>
              <select class="form-select form-select-sm" name="moneda" data-validate>
              <option value="" selected disabled>Seleccione una opción</option>
              <option value="SOLES">SOLES</option> 
              <option value="DOLARES">DOLARES</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Empresa</label>
              <select class="form-select form-select-sm" data-validate name="empresa">
                  <option value=""  selected disabled>Seleccione una opción</option>
                  <?php foreach ($empresas as $x) : ?>
                  <option value="<?php echo $x["EMP_id"] ?>"><?php echo $x["EMP_descripcion"] ?></option>
                  <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-6">
            <label>Revisor</label>
            <select class="form-select form-select-sm" data-validate name="revisor">
                <option value=""  selected disabled>Seleccione una opción</option>
                <?php foreach ($gerentes as $x) : ?>
                <option value="<?php echo $x["PER_acronimo"] ?>"><?php echo $x["PER_nombres"] ?></option>
                <?php endforeach ?>
            </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
            <label>Fecha de inicio</label>
            <input type="date" name="fechaInicio" class="form-control form-control-sm mb-2" data-validate >
            </div>
            <!-- <div class="col-md-6">
            <label>Fecha final</label>
            <input type="date" name="fechaFin" class="form-control form-control-sm mb-2" data-validate >
            </div> -->
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-sm btn-blue-gyt" onclick="agregaOrden()">AGREGAR</button>
      </div>
    </div>
  </div>
</div>
