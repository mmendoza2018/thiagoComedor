<?php
require_once "../../conexion.php";

$resDepartamentos = mysqli_query($conexion, "SELECT * FROM departamentos");
$resDistritos = mysqli_query($conexion, "SELECT * FROM distritos");
$resProvincias = mysqli_query($conexion, "SELECT * FROM provincias");
?>
<link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>
<!-- Modal actualiza tipo equipos -->
<div class="modal fade" id="modalActPersonal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h5 class="modal-title mx-auto" id="staticBackdropLabel">Editar Personal</h5>
      </div>
      <div class="modal-body">
        <!-- SmartWizard html -->
        <div id="smartwizardAct">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="#step-1">
                <div class="num">1</div>
                personales (1)
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#step-2">
                <span class="num">2</span>
                personales (2)
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#step-3">
                <span class="num">3</span>
                Educación / Experiencia
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="#step-4">
                <span class="num">4</span>
                Laborales
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="#step-5">
                <span class="num">4</span>
                Bancarios
              </a>
            </li>
          </ul>
          <form id="formActPersonal">
            <div class="tab-content mt-3">
              <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                <div class="row" style="min-height: 340px;">
                  <div class="col-md-4">
                    <label>Num. Doc</label>
                    <input type="hidden" id="idPerAct" name="id">
                    <input type="number" name="numDocumento" id="numDocumentoPerAct" data-validate class="form-control form-control-sm" required="">
                    <label>Nombres</label>
                    <input type="text" name="nombres" id="nombresPerAct" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
                    <label>Apellidos Pat./Mat.</label>
                    <input type="text" name="apellidos" data-validate id="apellidosPerAct" class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
                    <label>Fecha Nacimiento</label>
                    <input type="date" name="fechaNacimiento" id="fechaNacimientoPerAct" data-validate class="form-control form-control-sm" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                    <label>Departamento (nacimiento)</label>
                    <select onchange="selectChange(this,'php/recursosHumanos/personal/optionsProvincia.php','provinciaPerAct')" class="form-select form-select-sm" data-validate name="departamentoNac" id="departamentoNacPerAct" required="">
                      <option value="">-- SELECCIONE --</option>
                      <?php foreach ($resDepartamentos as $x) : ?>
                        <option value="<?php echo $x["DEPA_id"] ?>"><?php echo $x["DEPA_descripcion"] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <label>Provincia (nacimiento)</label>
                    <select id="provinciaNacPerAct" onchange="selectChange(this,'php/recursosHumanos/personal/optionsDistrito.php','distritoPerAct')" class="form-select form-select-sm" data-validate name="provinciaNac" required="">
                      <option value="">-- SELECCIONE --</option>
                      <?php foreach ($resProvincias as $x) : ?>
                        <option value="<?php echo $x["PROVI_id"] ?>"><?php echo $x["PROVI_descripcion"] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <label>Distrito (nacimiento)</label>
                    <select id="distritoNacPerAct" class="form-select form-select-sm" data-validate name="distritoNac" required="">
                      <option value="">-- SELECCIONE --</option>
                      <?php foreach ($resDistritos as $x) : ?>
                        <option value="<?php echo $x["DISTRI_id"] ?>"><?php echo $x["DISTRI_descripcion"] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <label>Tipo Sangre</label>
                    <select class="form-select form-select-sm select2" id="sangrePerAct" data-validate name="sangre">
                      <option value="">-- SELECCIONE --</option>
                      <option>O NEGATIVO</option>
                      <option>O POSITIVO</option>
                      <option>A NEGATIVO</option>
                      <option>A POSITIVO</option>
                      <option>B NEGATIVO</option>
                      <option>B POSITIVO</option>
                      <option>AB NEGATIVO</option>
                      <option>AB POSITIVO</option>
                    </select>

                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">

                    <label>Correo</label>
                    <input type="email" name="correo" id="correoPerAct" class="form-control form-control-sm" data-validate>
                    <label>Teléfono</label>
                    <input type="number" name="telefono" id="telefonoPerAct" class="form-control form-control-sm" data-validate>
                    <label>Celular</label>
                    <input type="number" name="celular" id="celularPerAct" class="form-control form-control-sm" data-validate>
                    <label>Telefonos de emergencia</label>
                    <input type="text" name="telefonosEmergencia" id="telefonosEmergenciaPerAct" class="form-control form-control-sm" data-validate>
                    <label>Persona de contacto</label>
                    <input type="text" name="personaEmergencia" id="personaEmergenciaPerAct" class="form-control form-control-sm" data-validate>
                    <label>Parentesco</label>
                    <input type="text" name="personaParentesco" id="personaParentescoPerAct" class="form-control form-control-sm" data-validate>
                    <label>Direccion</label>
                    <input type="text" name="direccion" id="direccionPerAct" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <label>Referencia</label>
                    <input type="text" name="referencia" id="referenciaPerAct" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">

                    <!-- /.form-group -->
                  </div>
                  <div class="col-md-4">
                    <!-- /.form-group -->
                    <label>Departamento (actual)</label>
                    <select onchange="selectChange(this,'php/recursosHumanos/personal/optionsProvincia.php','provinciaActPerAct')" class="form-select form-select-sm" data-validate name="departamentoAct" id="departamentoActPerAct" required="">
                      <option value="">-- SELECCIONE --</option>
                      <?php foreach ($resDepartamentos as $x) : ?>
                        <option value="<?php echo $x["DEPA_id"] ?>"><?php echo $x["DEPA_descripcion"] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <label>Provincia (actual)</label>
                    <select id="provinciaActPerAct" onchange="selectChange(this,'php/recursosHumanos/personal/optionsDistrito.php','distritoActPerAct')" class="form-select form-select-sm" data-validate name="provinciaAct" required="">
                      <option value="">-- SELECCIONE --</option>
                      <?php foreach ($resProvincias as $x) : ?>
                        <option value="<?php echo $x["PROVI_id"] ?>"><?php echo $x["PROVI_descripcion"] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <label>Distrito (actual)</label>
                    <select id="distritoActPerAct" class="form-select form-select-sm" data-validate name="distritoAct">
                      <option value="">-- SELECCIONE --</option>
                      <?php foreach ($resDistritos as $x) : ?>
                        <option value="<?php echo $x["DISTRI_id"] ?>"><?php echo $x["DISTRI_descripcion"] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <label>Talla de chaqueta</label>
                    <input type="text" name="tallaChaqueta" id="tallaChaquetaPerAct" class="form-control form-control-sm" data-validate>
                    <label>Talla de Camisa/polo</label>
                    <input type="text" name="tallaCamisa" id="tallaCamisaPerAct" class="form-control form-control-sm" data-validate>
                    <label>Talla de pantalon</label>
                    <input type="text" name="tallaPantalon" id="tallaPantalonPerAct" class="form-control form-control-sm" data-validate>
                    <label>Talla de zapatos</label>
                    <input type="text" name="tallaZapatos" id="tallaZapatosPerAct" class="form-control form-control-sm" data-validate>

                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

              </div>
              <div id="step-2" class="tab-pane px-2 h-100" style="overflow-y: auto; min-height: 330px;" role="tabpanel" aria-labelledby="step-2">
                <div class="row">
                  <div class="col-12">
                    <div>
                      <b class="text-center">Derechohabientes</b>
                      <div class="mt-2" id="llegaInputsDerechoHabientes">
                      </div>
                      <button class="btn btn-sm btn-warning mt-2" onclick="clonarElemento('inputCloneDerechoHaAct')" type="button">Nuevo</button>
                    </div>
                    <!-- /.form-group -->
                  </div>
                </div>
                <div class="row my-2">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-4">
                        <label>La casa que actualmente habita</label>
                        <select class="form-select form-select-sm select2" data-validate name="casaActual" id="casaActualPerAct" style="width: 100%;">
                          <option value="">-- SELECCIONE --</option>
                          <option>Propia</option>
                          <option>Alquilada</option>
                          <option>Familiar</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label>Posee vehiculo propio</label>
                        <select class="form-select form-select-sm select2" id="vehiculoPropioPerAct" data-validate name="vehiculoPropio" onchange="determinaVehiculo(this,'llegaVehiculoSelectAct')">
                          <option value="">-- SELECCIONE --</option>
                          <option>SI</option>
                          <option>NO</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <div id="llegaVehiculoSelectAct">

                        </div>
                      </div>
                    </div>
                    <!-- /.form-group -->
                  </div>
                </div>
                <!-- /.col -->

                <!-- /.col -->
              </div>
              <div id="step-3" class="tab-pane h-100" role="tabpanel" aria-labelledby="step-3" style="overflow-y: auto; min-height: 330px;">
                <div class="row mx-0">
                  <div>
                    <b class="text-center">Educación</b>
                    <div class="mt-1" id="llegaInputsEstudios">
                    </div>
                    <button class="btn btn-sm btn-warning mt-2" onclick="clonarElemento('inputCloneEstudiosAct')" type="button">Nuevo</button>
                  </div>

                  <div>
                    <b class="text-center">Otros estudios</b>
                    <div class="mt-1" id="llegaOtrosEstudiosAct">
                    </div>
                    <button class="btn btn-sm btn-warning mt-2" onclick="clonarElemento('inputCloneOtrosEstudiosAct')" type="button">Nuevo</button>
                  </div>

                  <div>
                    <b class="text-center">Experiencia</b>
                    <div class="mt-1" id="llegaExperienciaAct">
                    </div>
                    <button class="btn btn-sm btn-warning mt-2" onclick="clonarElemento('inputCloneExperienciaAct')" type="button">Nuevo</button>
                  </div>
                </div>
              </div>
              <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                <div class="row">
                  <div class="col-md-4">
                    <label>Sistema de pensiones </label>
                    <select class="form-select form-select-sm select2" onchange="determinaSisPensiones(this,'llegaSelectAfpAct');" data-validate name="sistemaPensiones" id="sistemaPensionesPerAct" style="width: 100%;">
                      <option value="">-- SELECCIONE --</option>
                      <option>ONP</option>
                      <option>AFP</option>
                    </select>
                    <!-- /.form-group -->
                  </div>
                  <div class="col-md-4">
                    <label>C.U.S.P.P</label>
                    <input type="text" name="cuspp" id="cusppPerAct" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <!-- /.form-group -->
                  </div>
                  <div class="col-md-4">
                    <div id="llegaSelectAfpAct">

                    </div>
                    <!-- /.form-group -->
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label>Durante el 2019 ¿Ha percibido ingresos por concepto de renta de quinta en algún trabajo anterior?</label>
                    <select class="form-select form-select-sm select2" id="quintaCategoria1PerAct" data-validate name="quintaCategoria1">
                      <option value="">-- SELECCIONE --</option>
                      <option>SI</option>
                      <option>NO</option>
                    </select>
                    <!-- /.form-group -->
                  </div>
                  <div class="col-md-4">
                    <label>¿Percibe ingresos adicionales de renta de quinta?</label>
                    <select class="form-select form-select-sm select2" id="quintaCategoria2PerAct" 
                    onchange="determinaIngresos5ta(this,'llegaIngresos5taAct');" data-validate name="quintaCategoria2">
                      <option value="">-- SELECCIONE --</option>
                      <option>SI</option>
                      <option>NO</option>
                    </select>
                    <!-- /.form-group -->
                  </div>
                  <div class="col-md-4">
                    <div id="llegaIngresos5taAct">

                    </div>
                    <!-- /.form-group -->
                  </div>
                </div>
              </div>
              <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                <div class="row">
                  <div class="col-md-4">
                    <label>Nro. cuenta (sueldo) </label>
                    <input type="text" name="cuentaSueldo" id="cuentaSueldoPerAct" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">

                    <!-- /.form-group -->
                  </div>
                  <div class="col-md-4">
                    <label>Banco(sueldo) </label>
                    <select class="form-select form-select-sm select2" id="bancoSueldoPerAct" data-validate name="bancoSueldo" style="width: 100%;">
                      <option value="">-- SELECCIONE --</option>
                      <option>INTERBANK</option>
                      <option>BANCO FALABELLA</option>
                      <option>CONTINENTAL</option>
                      <option>SCOTIABANK</option>
                      <option>BANCO DE CRÉDITO DEL PERÚ</option>
                    </select>
                    <!-- /.form-group -->
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label>Nro. cuenta (CTS)</label>
                    <input type="text" name="cuentaCts" id="cuentaCtsPerAct" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">

                    <!-- /.form-group -->
                  </div>
                  <div class="col-md-4">
                    <label>Banco (CTS)</label>
                    <select class="form-select form-select-sm select2" id="bancoCtsPerAct" data-validate name="bancoCts">
                      <option value="">-- SELECCIONE --</option>
                      <option>INTERBANK</option>
                      <option>BANCO FALABELLA </option>
                      <option>CONTINENTAL</option>
                      <option>BANCO DE CRÉDITO DEL PERÚ </option>
                      <option>BANCO FINANCIERO</option>
                      <option>BANBIF</option>
                      <option>SCOTIABANK</option>
                      <option>CAJA AREQUIPA</option>
                    </select>
                    <!-- /.form-group -->
                  </div>
                </div>
              </div>
            </div>
          </form>
          <!-- Include optional progressbar HTML -->
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- fin modal -->