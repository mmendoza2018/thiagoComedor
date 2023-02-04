<?php
require_once('modales.php');
require_once('../../conexion.php');

$resDepartamentos = mysqli_query($conexion, "SELECT * FROM departamentos");
$resUnidadesMineras = mysqli_query($conexion, "SELECT * FROM unidad_minera WHERE UNMI_estado = 1");

?>
<style>
  #formPersonalAdd label {
    font-weight: 600;
  }
</style>
<div>
  <h5>AGREGA PERSONAL</h5>
</div>
<div class="container-fluid bg-white my-2 py-3">
  <div class="row g-5">
    <div class="col-sm-12">
      <!-- SmartWizard html -->
      <div id="smartwizard">
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
        <form id="formPersonal">
          <div class="tab-content mt-3">
            <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
              <div class="row" style="min-height: 330px;">
                <div class="col-md-4">
                  <label>Num. Doc</label>
                  <input type="number" oninput="limitarTextoInput(this,undefined,8);" name="numDocumento" data-validate class="form-control form-control-sm" required="">
                  <label>Nombres</label>
                  <input type="text" name="nombres" data-validate id="nombres" class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
                  <label>Apellidos Pat./Mat.</label>
                  <input type="text" name="apellidos" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();" required="">
                  <label>Fecha Nacimiento</label>
                  <input type="date" name="fechaNacimiento" data-validate class="form-control form-control-sm" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                  <label>Departamento (nacimiento)</label>
                  <select onchange="selectChange(this,'php/recursosHumanos/personal/optionsProvincia.php','provinciaId')" class="form-select form-select-sm" data-validate name="departamentoNac" required="">
                    <option value="">-- SELECCIONE --</option>
                    <?php foreach ($resDepartamentos as $x) : ?>
                      <option value="<?php echo $x["DEPA_id"] ?>"><?php echo $x["DEPA_descripcion"] ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label>Provincia (nacimiento)</label>
                  <select id="provinciaId" onchange="selectChange(this,'php/recursosHumanos/personal/optionsDistrito.php','distritoId')" class="form-select form-select-sm" data-validate name="provinciaNac" required="">
                    <option value="">-- SELECCIONE --</option>
                  </select>
                  <label>Distrito (nacimiento)</label>
                  <select id="distritoId" class="form-select form-select-sm" data-validate name="distritoNac" required="">
                    <option value="">-- SELECCIONE --</option>
                  </select>
                  <label>Tipo Sangre</label>
                  <select class="form-select form-select-sm select2" name="sangre">
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
                  <input type="email" name="correo" class="form-control form-control-sm" data-validate>
                  <label>Teléfono</label>
                  <input type="number" name="telefono" class="form-control form-control-sm" data-validate>
                  <label>Celular</label>
                  <input type="number" name="celular" oninput="limitarTextoInput(this,false,9)" class="form-control form-control-sm" data-validate>
                  <label>Telefonos de emergencia</label>
                  <input type="text" name="telefonosEmergencia" class="form-control form-control-sm" data-validate>
                  <label>Persona de contacto</label>
                  <input type="text" name="personaEmergencia" class="form-control form-control-sm" data-validate>
                  <label>Parentesco</label>
                  <input type="text" name="personaParentesco" class="form-control form-control-sm" data-validate>
                  <label>Direccion</label>
                  <input type="text" name="direccion" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label>Referencia</label>
                  <input type="text" name="referencia" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">

                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <!-- /.form-group -->
                  <label>Departamento (actual)</label>
                  <select onchange="selectChange(this,'php/recursosHumanos/personal/optionsProvincia.php','provinciaId2')" class="form-select form-select-sm" data-validate name="departamentoAct" required="">
                    <option value="">-- SELECCIONE --</option>
                    <?php foreach ($resDepartamentos as $x) : ?>
                      <option value="<?php echo $x["DEPA_id"] ?>"><?php echo $x["DEPA_descripcion"] ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label>Provincia (actual)</label>
                  <select id="provinciaId2" onchange="selectChange(this,'php/recursosHumanos/personal/optionsDistrito.php','distritoId2')" class="form-select form-select-sm" data-validate name="provinciaAct" required="">
                    <option value="">-- SELECCIONE --</option>
                  </select>
                  <label>Distrito (actual)</label>
                  <select id="distritoId2" class="form-select form-select-sm" data-validate name="distritoAct">
                    <option value="">-- SELECCIONE --</option>
                  </select>
                  <label>Talla de chaqueta</label>
                  <input type="text" name="tallaChaqueta" class="form-control form-control-sm" data-validate>
                  <label>Talla de Camisa/polo</label>
                  <input type="text" name="tallaCamisa" class="form-control form-control-sm" data-validate>
                  <label>Talla de pantalon</label>
                  <input type="text" name="tallaPantalon" class="form-control form-control-sm" data-validate>
                  <label>Talla de zapatos</label>
                  <input type="text" name="tallaZapatos" class="form-control form-control-sm" data-validate>

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
                    <div class="mt-2">
                      <div class="row justify-content-center align-items-center" data-clone="" id="inputCloneDerechoHaAdd">
                        <div class="col-12 col-lg-3">
                          <label>Nombres y apellidos</label>
                          <input type="text" data-validate="" class="form-control form-control-sm" autocomplete="off">
                        </div>
                        <div class="col-12 col-lg-2">
                          <label>Vinculo</label>
                          <input type="text" data-validate="" class="form-control form-control-sm" autocomplete="off">
                        </div>
                        <div class="col-12 col-lg-2">
                          <label>F. Nacimiento</label>
                          <input type="date" data-validate="" class="form-control form-control-sm" autocomplete="off">
                        </div>
                        <div class="col-12 col-lg-2">
                          <label>Sexo</label>
                          <select data-validate="" class="form-select form-select-sm" id="">
                            <option value="">-- SELECCIONE --</option>
                            <option>masculino</option>
                            <option>femenino</option>
                            <option>Otro</option>
                          </select>
                        </div>
                        <div class="col-12 col-lg-2">
                          <label>DNI</label>
                          <input type="number" data-validate="" oninput="limitarTextoInput(this,false,8)" class="form-control form-control-sm" autocomplete="off">
                        </div>
                        <div class="col-1 d-flex justify-content-end">
                          <a href="#" class="text-danger mt-1"><i class="fas fa-minus-circle fa-2x mb-2" onclick="QuitarElemento(this)"></i></a>
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-sm btn-warning mt-2" onclick="clonarElemento('inputCloneDerechoHaAdd')" type="button">Nuevo</button>
                  </div>
                  <!-- /.form-group -->
                </div>
              </div>
              <div class="row my-2">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-4">
                      <label>La casa que actualmente habita</label>
                      <select class="form-select form-select-sm select2" data-validate name="casaActual" style="width: 100%;">
                        <option value="">-- SELECCIONE --</option>
                        <option>Propia</option>
                        <option>Alquilada</option>
                        <option>Familiar</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label>Posee vehiculo propio</label>
                      <select class="form-select form-select-sm select2" data-validate name="vehiculoPropio" onchange="determinaVehiculo(this,'llegaVehiculoSelect')">
                        <option value="">-- SELECCIONE --</option>
                        <option>SI</option>
                        <option>NO</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <div id="llegaVehiculoSelect">

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
                  <div class="mt-1">
                    <div class="row justify-content-center align-items-center" data-clone="" id="inputCloneEstudiosAdd">
                      <div class="col-12 col-lg-2">
                        <label>Estudios</label>
                        <select  class="form-select form-select-sm" data-validate>
                        <option value="">Selecione una opción</option>
                        <option value="Educación primaria">Educación primaria</option>
                        <option value="Educación secundaria">Educación secundaria</option>
                        <option value="Educación superior">Educación superior</option>
                        <option value="Educación tecnica">Educación tecnica</option>
                        </select>
                      </div>
                      <div class="col-12 col-lg-2">
                        <label>Institución</label>
                        <input type="text" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-12 col-lg-2">
                        <label>Espcialidad</label>
                        <input type="text" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-12 col-lg-1">
                        <label>Grado</label>
                        <input type="text" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-12 col-lg-2">
                        <label>Desde</label>
                        <input type="date" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-12 col-lg-2">
                        <label>Hasta</label>
                        <input type="date" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-1 d-flex justify-content-end">
                        <a href="#" class="text-danger mt-1"><i class="fas fa-minus-circle fa-2x mb-2" onclick="QuitarElemento(this)"></i></a>
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-sm btn-warning mt-2" onclick="clonarElemento('inputCloneEstudiosAdd')" type="button">Nuevo</button>
                </div>

                <div>
                  <b class="text-center">Otros estudios</b>
                  <div class="mt-1">
                    <div class="row justify-content-center align-items-center" data-clone="" id="inputCloneOtrosEstudiosAdd">
                      <div class="col-12 col-lg-4">
                        <label>Nombre del curso</label>
                        <input type="text" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-12 col-lg-3">
                        <label>institución</label>
                        <input type="text" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-12 col-lg-2">
                        <label>Desde</label>
                        <input type="date" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-12 col-lg-2">
                        <label>Hasta</label>
                        <input type="date" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-1 d-flex justify-content-end">
                        <a href="#" class="text-danger mt-1"><i class="fas fa-minus-circle fa-2x mb-2" onclick="QuitarElemento(this)"></i></a>
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-sm btn-warning mt-2" onclick="clonarElemento('inputCloneOtrosEstudiosAdd')" type="button">Nuevo</button>
                </div>

                <div>
                  <b class="text-center">Experiencia</b>
                  <div class="mt-1">
                    <div class="row justify-content-center align-items-center" data-clone="" id="inputCloneExperienciaAdd">
                      <div class="col-12 col-lg-3">
                        <label>Empresa</label>
                        <input type="text" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-12 col-lg-2">
                        <label>F. inicio</label>
                        <input type="date" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-12 col-lg-2">
                        <label>F. fin</label>
                        <input type="date" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-12 col-lg-2">
                        <label>cargo</label>
                        <input type="text" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-12 col-lg-2">
                        <label>Remuneración</label>
                        <input type="number" data-validate="" class="form-control form-control-sm" autocomplete="off">
                      </div>
                      <div class="col-1 d-flex justify-content-end">
                        <a href="#" class="text-danger mt-1"><i class="fas fa-minus-circle fa-2x mb-2" onclick="QuitarElemento(this)"></i></a>
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-sm btn-warning mt-2" onclick="clonarElemento('inputCloneExperienciaAdd')" type="button">Nuevo</button>
                </div>
              </div>
            </div>
            <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
              <div class="row">
                <div class="col-md-4">
                  <label>Sistema de pensiones </label>
                  <select class="form-select form-select-sm select2" onchange="determinaSisPensiones(this, 'llegaSelectAfp');" data-validate name="sistemaPensiones" style="width: 100%;">
                    <option value="">-- SELECCIONE --</option>
                    <option>ONP</option>
                    <option>AFP</option>
                  </select>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <label>C.U.S.P.P</label>
                  <input type="text" name="cuspp" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <div id="llegaSelectAfp">

                  </div>
                  <!-- /.form-group -->
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label>Durante el 2019 ¿Ha percibido ingresos por concepto de renta de quinta en algún trabajo anterior?</label>
                  <select class="form-select form-select-sm select2" data-validate name="quintaCategoria1">
                    <option value="">-- SELECCIONE --</option>
                    <option>SI</option>
                    <option>NO</option>
                  </select>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <label>¿Percibe ingresos adicionales de renta de quinta?</label>
                  <select class="form-select form-select-sm select2" onchange="determinaIngresos5ta(this,'llegaIngresos5ta');" data-validate name="quintaCategoria2">
                    <option value="">-- SELECCIONE --</option>
                    <option>SI</option>
                    <option>NO</option>
                  </select>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <div id="llegaIngresos5ta">

                  </div>
                  <!-- /.form-group -->
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">

                  <label>Unidad minera ( actual )</label>
                  <select class="form-select form-select-sm" data-validate name="unidadMinera">
                    <option value="">-- SELECCIONE --</option>
                    <?php foreach ($resUnidadesMineras as $x) : ?>
                      <option value="<?php echo $x["UNMI_id"] ?>"><?php echo $x["UNMI_descripcion"] ?></option>
                    <?php endforeach; ?>
                  </select>

                </div>
                <div class="col-md-4">
                  
                  <label>Estado trabajo</label>
                  <select class="form-select form-select-sm" data-validate name="estadoTrabajo">
                    <option value="">-- SELECCIONE --</option>
                    <option value="1">LABORANDO</option>
                    <option value="0">RETIRADO</option>
                  </select>

                </div>
              </div>
            </div>
            <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
              <div class="row">
                <div class="col-md-4">
                  <label>Nro. cuenta (sueldo) </label>
                  <input type="text" name="cuentaSueldo" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">

                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <label>Banco(sueldo) </label>
                  <select class="form-select form-select-sm select2" data-validate name="bancoSueldo" style="width: 100%;">
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
                  <input type="text" name="cuentaCts" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">

                  <!-- /.form-group -->
                </div>
                <div class="col-md-4">
                  <label>Banco (CTS)</label>
                  <select class="form-select form-select-sm select2" data-validate name="bancoCts">
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
  </div>
</div>

<script>
  setTimeout(() => {
    $('#smartwizard').smartWizard({
      lang: { // Language variables for button
        next: 'Siguiente',
        previous: 'Atras'
      },
      toolbar: {
        extraHtml: '<button class="btn btn-primary" type="submit" onclick="agregaPersonal()">Registrar</button>' // Extra html to show on toolbar
      },
    });
  }, 100);
</script>