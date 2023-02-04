const mostrarSelectSisPensiones = (
  idselect = "",
  idLlegada = "llegaSelectAfp"
) => {
  let select = `<label>Tipo AFP</label>
  <select class="form-select form-select-sm select2" id="${idselect}" data-validate name="tipoAfp" style="width: 100%;">
    <option value="">-- SELECCIONE --</option>
    <option>Integra</option>
    <option>Prima</option>
    <option>Profuturo</option>
    <option>Habitad</option>
  </select>`;

  document.getElementById(idLlegada).innerHTML = select;
};

const determinaSisPensiones = (elemento, idLlegada) => {
  if (elemento.value == "AFP") {
    mostrarSelectSisPensiones(undefined, idLlegada);
  } else {
    document.getElementById(idLlegada).innerHTML = "";
  }
};

const mostrarSelectIngresos5ta = (
  idselect = "",
  idLlegada = "llegaIngresos5ta"
) => {
  let select = `<label>Empresa</label>
  <input type="text" name="empresaIngresos5ta" id="${idselect}" data-validate class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">`;

  document.getElementById(idLlegada).innerHTML = select;
};

const determinaIngresos5ta = (elemento, idLlegada) => {
  if (elemento.value == "SI") {
    mostrarSelectIngresos5ta(undefined, idLlegada);
  } else {
    document.getElementById(idLlegada).innerHTML = "";
  }
};

const mostrarSelectVehiculo = (
  idselect = "",
  idLlegada = "llegaVehiculoSelect"
) => {
  let select = `<label>¿ Se encuentra cancelado ?</label>
  <select class="form-select form-select-sm select2" id="${idselect}" data-validate name="vehiculoCancelado" style="width: 100%;">
    <option value="">-- SELECCIONE --</option>
    <option>SI</option>
    <option>NO</option>
  </select>`;

  document.getElementById(idLlegada).innerHTML = select;
};

const determinaVehiculo = (elemento, idLlegada) => {
  if (elemento.value == "SI") {
    mostrarSelectVehiculo(undefined, idLlegada);
  } else {
    document.getElementById(idLlegada).innerHTML = "";
  }
};

const agregaPersonal = () => {
  event.preventDefault();
  let formulario = document.getElementById("formPersonal");
  if (!validar_campos("formPersonal"))
    return toastPersonalizada(
      "¡ Complete todos los campos necesarios !",
      "warning"
    );
  /* verLoader(); */
  let data = new FormData(formulario);
  let dataDerechoHaAdd = obtenerListaDatosMultiples("inputCloneDerechoHaAdd");
  let dataEstudiosAdd = obtenerListaDatosMultiples("inputCloneEstudiosAdd");
  let dataOtrosEstudiosAdd = obtenerListaDatosMultiples(
    "inputCloneOtrosEstudiosAdd"
  );
  let dataExperienciaAdd = obtenerListaDatosMultiples(
    "inputCloneExperienciaAdd"
  );

  data.append("dataDerechoHaAdd", dataDerechoHaAdd);
  data.append("dataEstudiosAdd", dataEstudiosAdd);
  data.append("dataOtrosEstudiosAdd", dataOtrosEstudiosAdd);
  data.append("dataExperienciaAdd", dataExperienciaAdd);

  fetch("php/recursosHumanos/personal/agrega.php", {
    method: "POST",
    body: data,
  })
    .then((res) => res.json())
    .then((respuesta) => {
      console.log(respuesta);
      if (respuesta[0]) {
        $("#modalAddAtencionesDelDia").modal("hide");
        alertaPersonalizada("Agregado con exito!", "success");
        cargarContenido("php/recursosHumanos/personal/index.php", "contenido");
      } else {
        alertaPersonalizada(respuesta[1], "error");
      }
      ocultarLoader();
    });
};
const obtenerListaDatosMultiples = (idInputsClone) => {
  // crear json derechohabientes
  let listaConjunto = document.querySelectorAll(`#${idInputsClone}`);
  let arrayDerechoHabientes = [];

  console.log("listaConjunto", listaConjunto);

  listaConjunto.forEach((el) => {
    let arrayList = Array.prototype.slice.call(
      el.querySelectorAll("input, select")
    );
    let newarrayList = arrayList.map((e) => e.value);
    let arrayInputs = [];

    arrayInputs.push(...newarrayList);
    arrayDerechoHabientes.push(arrayInputs);
  });

  return JSON.stringify(arrayDerechoHabientes);
};

const llenarPersonas = (idPersona) => {
  let data = new FormData();
  data.append("idPersona", idPersona);

  fetch("php/recursosHumanos/personal/dataPersona.php", {
    method: "POST",
    body: data,
  })
    .then((res) => res.json())
    .then((json) => {
      console.log("json", json);

      let { telefonos, persona, parentesco } = JSON.parse(json.PER_contacto);
      let { chaqueta, camisa, pantalon, zapatos } = JSON.parse(
        json.PER_implementos
      );

      document.getElementById("idPerAct").value = json.PER_id;
      document.getElementById("numDocumentoPerAct").value = json.PER_usuario;
      document.getElementById("nombresPerAct").value = json.PER_nombres;
      document.getElementById("apellidosPerAct").value = json.PER_apellidos;
      document.getElementById("fechaNacimientoPerAct").value =
        json.PER_fecha_nacimiento;
      document.getElementById("departamentoNacPerAct").value =
        json.PER_departamento_nac;
      document.getElementById("provinciaNacPerAct").value =
        json.PER_provincia_nac;
      document.getElementById("distritoNacPerAct").value =
        json.PER_distrito_nac;
      document.getElementById("sangrePerAct").value = json.PER_sangre;
      document.getElementById("correoPerAct").value = json.PER_correo;
      document.getElementById("telefonoPerAct").value = json.PER_telefono;
      document.getElementById("celularPerAct").value = json.PER_celular;
      document.getElementById("telefonosEmergenciaPerAct").value = telefonos;
      document.getElementById("personaEmergenciaPerAct").value = persona;
      document.getElementById("personaParentescoPerAct").value = parentesco;
      document.getElementById("direccionPerAct").value = json.PER_direccion;
      document.getElementById("referenciaPerAct").value = json.PER_referencia;
      document.getElementById("departamentoActPerAct").value =
        json.PER_departamento;
      document.getElementById("provinciaActPerAct").value = json.PER_provincia;
      document.getElementById("distritoActPerAct").value = json.PER_distrito;
      document.getElementById("tallaChaquetaPerAct").value = chaqueta;
      document.getElementById("tallaCamisaPerAct").value = camisa;
      document.getElementById("tallaPantalonPerAct").value = pantalon;
      document.getElementById("tallaZapatosPerAct").value = zapatos;
      document.getElementById("casaActualPerAct").value = json.PER_vivienda;
      document.getElementById("vehiculoPropioPerAct").value = json.PER_vehiculo;
      document.getElementById("unidadMineraPerAct").value = json.UNMI_id01;
      document.getElementById("estadoTrabajoPerAct").value =
        json.PER_estado_trabajo;

      document.getElementById("llegaVehiculoSelectAct").innerHTML = "";
      if (!json.PER_vehiculo_pagado == "") {
        mostrarSelectVehiculo(
          "vehiculoCanceladoPerAct",
          "llegaVehiculoSelectAct"
        );
        document.getElementById("vehiculoCanceladoPerAct").value =
          json.PER_vehiculo_pagado;
      }
      document.getElementById("sistemaPensionesPerAct").value =
        json.PER_sis_pension;
      document.getElementById("cusppPerAct").value = json.PER_cuspp;
      document.getElementById("quintaCategoria1PerAct").value =
        json.PER_5ta_ingresos;
      document.getElementById("quintaCategoria2PerAct").value =
        json.PER_5ta_adicional;
      document.getElementById("llegaIngresos5taAct").innerHTML = "";
      if (!json.PER_5ta_empresa == "") {
        mostrarSelectIngresos5ta(
          "empresaIngresos5taPerAct",
          "llegaIngresos5taAct"
        );
        document.getElementById("empresaIngresos5taPerAct").value =
          json.PER_5ta_empresa;
      }
      document.getElementById("cuentaSueldoPerAct").value =
        json.PER_cuenta_sueldo;
      document.getElementById("bancoSueldoPerAct").value =
        json.PER_banco_sueldo;
      document.getElementById("cuentaCtsPerAct").value = json.PER_cuenta_cts;
      document.getElementById("bancoCtsPerAct").value = json.PER_banco_cts;
      document.getElementById("llegaSelectAfpAct").innerHTML = "";
      if (!json.PER_afp == "") {
        mostrarSelectSisPensiones("tipoAfpPerAct", "llegaSelectAfpAct");
        document.getElementById("tipoAfpPerAct").value = json.PER_afp;
      }

      // render derecho habientes
      let llegadaderechoHabientes = document.getElementById(
        "llegaInputsDerechoHabientes"
      );
      llegadaderechoHabientes.innerHTML = "";

      JSON.parse(json.PER_derecho_habientes).forEach((el) => {
        let listaDerechoHabientes = `
        <div class="col-3">
          <label>Nombres y apellidos</label>
          <input type="text" data-validate="" value="${el[0]}" class="form-control form-control-sm" autocomplete="off">
        </div>
        <div class="col-2">
          <label>Vinculo</label>
          <input type="text" data-validate="" value="${el[1]}" class="form-control form-control-sm" autocomplete="off">
        </div>
        <div class="col-2">
          <label>F. Nacimiento</label>
          <input type="date" data-validate="" value="${el[2]}" class="form-control form-control-sm" autocomplete="off">
        </div>
        <div class="col-2">
          <label>Sexo</label>
          <select data-validate="" class="form-select form-select-sm" id="">
            <option value="">-- SELECCIONE --</option>
            <option>masculino</option>
            <option>femenino</option>
            <option>Otro</option>
          </select>
        </div>
        <div class="col-2">
          <label>DNI</label>
          <input type="number" data-validate="" value="${el[4]}" class="form-control form-control-sm" autocomplete="off">
        </div>
        <div class="col-1 d-flex justify-content-end">
          <a href="#" class="text-danger mt-1"><i class="fas fa-minus-circle fa-2x mb-2" onclick="QuitarElemento(this)"></i></a>
        </div>`;
        let div = document.createElement("div");

        div.classList.add(
          "row",
          "justify-content-center",
          "align-items-center"
        );
        div.setAttribute("data-clone", "");
        div.setAttribute("id", "inputCloneDerechoHaAct");
        div.innerHTML = listaDerechoHabientes;
        llegadaderechoHabientes.insertAdjacentElement("beforeend", div);
        div.querySelector("select").value = el[3];
      });

      // render estudios
      let llegadaEstudios = document.getElementById("llegaInputsEstudios");
      llegadaEstudios.innerHTML = "";
      JSON.parse(json.PER_estudios).forEach((el) => {
        let listaEstudios = `
                        <div class="col-2">
                          <label>Estudios</label>
                          <select  class="form-select form-select-sm" data-validate>
                            <option value="">Selecione una opción</option>
                            <option value="Educación primaria">Educación primaria</option>
                            <option value="Educación secundaria">Educación secundaria</option>
                            <option value="Educación superior">Educación superior</option>
                            <option value="Educación tecnica">Educación tecnica</option>
                          </select>
                        </div>
                        <div class="col-2">
                          <label>Institución</label>
                          <input type="text" data-validate="" value="${el[1]}"  class="form-control form-control-sm" autocomplete="off">
                        </div>
                        <div class="col-2">
                          <label>Espcialidad</label>
                          <input type="text" data-validate="" value="${el[2]}"  class="form-control form-control-sm" autocomplete="off">
                        </div>
                        <div class="col-1">
                          <label>Grado</label>
                          <input type="text" data-validate="" value="${el[3]}"  class="form-control form-control-sm" autocomplete="off">
                        </div>
                        <div class="col-2">
                          <label>Desde</label>
                          <input type="date" data-validate="" value="${el[4]}"  class="form-control form-control-sm" autocomplete="off">
                        </div>
                        <div class="col-2">
                          <label>Hasta</label>
                          <input type="date" data-validate="" value="${el[5]}"  class="form-control form-control-sm" autocomplete="off">
                        </div>
                        <div class="col-1 d-flex justify-content-end">
                          <a href="#" class="text-danger mt-1"><i class="fas fa-minus-circle fa-2x mb-2" onclick="QuitarElemento(this)"></i></a>
                        </div>`;
        let div2 = document.createElement("div");

        div2.classList.add(
          "row",
          "justify-content-center",
          "align-items-center"
        );
        div2.setAttribute("data-clone", "");
        div2.setAttribute("id", "inputCloneEstudiosAct");
        div2.innerHTML = listaEstudios;
        llegadaEstudios.insertAdjacentElement("beforeend", div2);
        div2.querySelector("select").value = el[0];
      });

      // render otros estudios
      let llegadaOtrosEstudios = document.getElementById(
        "llegaOtrosEstudiosAct"
      );
      llegadaOtrosEstudios.innerHTML = "";
      JSON.parse(json.PER_otros_estudios).forEach((el) => {
        let listaOtrosEstudios = `
              <div class="col-4">
              <label>Nombre del curso</label>
              <input type="text" data-validate="" value="${el[0]}" class="form-control form-control-sm" autocomplete="off">
            </div>
            <div class="col-3">
              <label>institución</label>
              <input type="text" data-validate="" value="${el[1]}" class="form-control form-control-sm" autocomplete="off">
            </div>
            <div class="col-2">
              <label>Desde</label>
              <input type="date" data-validate="" value="${el[2]}" class="form-control form-control-sm" autocomplete="off">
            </div>
            <div class="col-2">
              <label>Hasta</label>
              <input type="date" data-validate="" value="${el[3]}" class="form-control form-control-sm" autocomplete="off">
            </div>
            <div class="col-1 d-flex justify-content-end">
              <a href="#" class="text-danger mt-1"><i class="fas fa-minus-circle fa-2x mb-2" onclick="QuitarElemento(this)"></i></a>
            </div>`;
        let div3 = document.createElement("div");

        div3.classList.add(
          "row",
          "justify-content-center",
          "align-items-center"
        );
        div3.setAttribute("data-clone", "");
        div3.setAttribute("id", "inputCloneOtrosEstudiosAct");
        div3.innerHTML = listaOtrosEstudios;
        llegadaOtrosEstudios.insertAdjacentElement("beforeend", div3);
      });

      // render experiencia
      let llegadaExperiencia = document.getElementById("llegaExperienciaAct");
      llegadaExperiencia.innerHTML = "";
      JSON.parse(json.PER_experiencia).forEach((el) => {
        let listaExperiencia = `
        <div class="col-3">
        <label>Empresa</label>
        <input type="text" data-validate="" value="${el[0]}" class="form-control form-control-sm" autocomplete="off">
      </div>
      <div class="col-2">
        <label>F. inicio</label>
        <input type="date" data-validate="" value="${el[1]}" class="form-control form-control-sm" autocomplete="off">
      </div>
      <div class="col-2">
        <label>F. fin</label>
        <input type="date" data-validate="" value="${el[2]}" class="form-control form-control-sm" autocomplete="off">
      </div>
      <div class="col-2">
        <label>cargo</label>
        <input type="text" data-validate="" value="${el[3]}" class="form-control form-control-sm" autocomplete="off">
      </div>
      <div class="col-2">
        <label>Remuneración</label>
        <input type="number" data-validate="" value="${el[4]}" class="form-control form-control-sm" autocomplete="off">
      </div>
      <div class="col-1 d-flex justify-content-end">
        <a href="#" class="text-danger mt-1"><i class="fas fa-minus-circle fa-2x mb-2" onclick="QuitarElemento(this)"></i></a>
      </div>`;
        let div4 = document.createElement("div");

        div4.classList.add(
          "row",
          "justify-content-center",
          "align-items-center"
        );
        div4.setAttribute("data-clone", "");
        div4.setAttribute("id", "inputCloneExperienciaAct");
        div4.innerHTML = listaExperiencia;
        llegadaExperiencia.insertAdjacentElement("beforeend", div4);
      });
    });
};

const actualizaPersonal = () => {
  event.preventDefault();
  let formulario = document.getElementById("formActPersonal");
  if (!validar_campos("formActPersonal"))
    return toastPersonalizada(
      "¡ Complete todos los campos necesarios !",
      "warning"
    );
  /* verLoader(); */
  Swal.fire({
    title: "¿Estas seguro de actualizar?",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "si",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      verLoader();
      let data = new FormData(formulario);
      let dataDerechoHaAct = obtenerListaDatosMultiples(
        "inputCloneDerechoHaAct"
      );
      let dataEstudiosAct = obtenerListaDatosMultiples("inputCloneEstudiosAct");
      let dataOtrosEstudiosAct = obtenerListaDatosMultiples(
        "inputCloneOtrosEstudiosAct"
      );
      let dataExperienciaAct = obtenerListaDatosMultiples(
        "inputCloneExperienciaAct"
      );

      data.append("dataDerechoHaAct", dataDerechoHaAct);
      data.append("dataEstudiosAct", dataEstudiosAct);
      data.append("dataOtrosEstudiosAct", dataOtrosEstudiosAct);
      data.append("dataExperienciaAct", dataExperienciaAct);

      fetch("php/recursosHumanos/personal/actualiza.php", {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then((respuesta) => {
          console.log(respuesta);
          if (respuesta) {
            $("#modalActPersonal").modal("hide");
            alertaPersonalizada("Actualizado con exito!", "success");
            cargarContenido(
              "php/recursosHumanos/personal/tabla.php",
              "contenido"
            );
          } else {
            alertaPersonalizada("Fallo Al actualizar", "error");
          }
          ocultarLoader();
        });
    }
  });
};

// documentos

const agregarDocumentoPersonal = (formulario) => {
  event.preventDefault();
  if (!validar_campos("formAddDocumentoPer"))
    return toastPersonalizada(
      "Algunos campos omitidos son obligatorios",
      "warning"
    );
  verLoader();
  let data = new FormData(formulario);
  fetch("php/recursosHumanos/documentos/agrega.php", {
    method: "POST",
    body: data,
  })
    .then((res) => res.json())
    .then((json) => {
      console.log("json", json);
      if (json) {
        alertaPersonalizada("Agregado correctamente!", "success", 2000);
        cargarContenido(
          "php/recursosHumanos/documentos/index.php",
          "contenido"
        );
      } else {
        alertaPersonalizada("Ocurrio un error al agregar!", "error", 2000);
      }
      ocultarLoader();
    });
};
const obtenerListaDocsPer = (idPersona) => {
  let data = new FormData();
  data.append("idPersona", idPersona);
  cargarContenido(
    "php/recursosHumanos/documentos/listaDocumentos.php",
    "llegaListaDocPer",
    {
      method: "POST",
      body: data,
    }
  );
};

const verDocumentoPersonal = (idDocumento) => {
  let data = new FormData();
  data.append("idDocumento", idDocumento);
  cargarContenido(
    "php/recursosHumanos/documentos/verDocumento.php",
    "llegaPdfPersonal",
    {
      method: "POST",
      body: data,
    },
    true
  );
};

const llenarDocumentosAct = (data, isMonitorAlerta) => {
  let [
    idDocumento,
    idPersona,
    idTipoDoc,
    fecha1,
    fecha2,
    numDoc,
    descripcion,
    empresa,
    observacion,
    idPersonaAux,
  ] = data.split("|");

  //Obtener lista de personas y tipos de doc.
  let arrayPromesas = [
    fetch("php/recursosHumanos/documentos/optionslista.php"),
    fetch("php/recursosHumanos/personal/optionslista.php"),
  ];

  Promise.all(arrayPromesas.map((prom) => prom.then((res) => res.text()))).then(
    (resultado) => {
      console.log("resultado", resultado[0]);
      console.log("resultado", resultado[1]);
      document.getElementById("idPersonaActDoc").innerHTML = resultado[1];
      document.getElementById("idTipoDocActDOc").innerHTML = resultado[0];
      console.log("idPersona", idPersona);
      console.log("idTipoDoc", idTipoDoc);
      document.getElementById("idPersonaActDoc").value = idPersona;
      document.getElementById("idTipoDocActDOc").value = idTipoDoc;
      $(".select2").select2({
        placeholder: "Seleccione una opcion",
        dropdownParent: $("#modalActDocPersonal"),
        width: "100%",
      });
      $(document).on("select2:open", () => {
        document.querySelector(".select2-search__field").focus();
      });
    }
  );

  document.getElementById("idDocAct").value = idDocumento;
  document.getElementById("idTipoDocActDOc").click();
  document.getElementById("fInicioDocAct").value = fecha1;
  document.getElementById("fFinDocAct").value = fecha2;
  document.getElementById("numeroDocAct").value = numDoc;
  document.getElementById("descripcionDocAct").value = descripcion;
  document.getElementById("empresaDocAct").value = empresa;
  document.getElementById("observacionesDocAct").value = observacion;
  document.getElementById("idPersonaAuxiliar").value = idPersonaAux;
  document.getElementById("idBtnActDocs").dataset.tabla = isMonitorAlerta;
};
const actualizaDocumentoPer = (elemento) => {
  if (validar_campos("formActDocPersonal")) {
    Swal.fire({
      title: "¿Estas seguro de actualizar?",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "si",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        let formulario = document.getElementById("formActDocPersonal");
        let data = new FormData(formulario);
        let monitorAlerta = elemento.dataset.tabla;
        fetch("php/recursosHumanos/documentos/actualiza.php", {
          method: "POST",
          body: data,
        })
          .then((res) => res.json())
          .then((json) => {
            if (json) {
              alertaPersonalizada("Actualizado correctamente !", "success");
              $("#modalActDocPersonal").modal("hide");
              let idPersonaAux =
                document.getElementById("idPersonaAuxiliar").value;
              let modalMonitorAlertas = document.getElementById(
                "modalVerTablaMonitor"
              );
              if (modalMonitorAlertas.classList.contains("show")) {
                cargarContenido(
                  "php/recursosHumanos/documentos/tablaMonitor.php",
                  "llegaTablaALertaDocs"
                );
              } else {
                if (monitorAlerta === "true") {
                  cargarContenido(
                    "php/recursosHumanos/documentos/tablaMonitor.php",
                    "contenidoGeneral"
                  );
                } else {
                  obtenerListaDocsPer(idPersonaAux);
                }
              }
            } else {
              alertaPersonalizada("Ocurrio algun error!", "error");
            }
          });
      }
    });
  }
};

const reporteExcelDocumentosVencidos = (formulario) => {
  //array para enviar data de acuerdo el value del select
  event.preventDefault();
  if (!validar_campos("formReporteDocumentosVencer"))
    return toastPersonalizada("Algunos Campos son necesarios", "error");

  let idUnidadMinera = formulario.unidadMinera.value;
  let idTipoDocumento = formulario.tipoDocumento.value;
  let unidadMinera =
    formulario.unidadMinera.options[formulario.unidadMinera.selectedIndex].text;
  let tipoDocumento =
    formulario.tipoDocumento.options[formulario.tipoDocumento.selectedIndex]
      .text;
  let fechainicio = formulario.fecha1.value;
  let fechaFin = formulario.fecha2.value;
  let ruta = "php/generaEXCEL/reporteDocVencidos/index.php";

  if (idUnidadMinera === "") {
    unidadMinera = "-";
  }
  if (idTipoDocumento === "") {
    tipoDocumento = "-";
  }

  window.open(
    `${ruta}
    ?idUnidadMinera=${idUnidadMinera}&unidadMinera=${unidadMinera}&idTipoDocumento=${idTipoDocumento}&tipoDocumento=${tipoDocumento}&fInicio=${fechainicio}&fFinal=${fechaFin}`,
    "Documentos"
  );
};

const reporteExcelTrabajadores = (formulario) => {
  //array para enviar data de acuerdo el value del select
  event.preventDefault();

  let estadoTrabajador = formulario.estadoTrabajador.value;
  let idUnidadMinera = formulario.unidadMinera.value;
  let unidadMinera =
    formulario.unidadMinera.options[formulario.unidadMinera.selectedIndex].text;
  let ruta = "php/generaEXCEL/reporteTrabajadores/index.php";

  if (idUnidadMinera === "") {
    unidadMinera = "-";
  }

  window.open(
    `${ruta}
    ?idUnidadMinera=${idUnidadMinera}&unidadMinera=${unidadMinera}&estadoTrabajador=${estadoTrabajador}`,
    "Trabajadores"
  );
};
