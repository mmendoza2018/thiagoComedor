function agregarAtenciones() {
  event.preventDefault();
  if (validar_campos("formAddAtenciones")) {
    let formulario = document.getElementById("formAddAtenciones");
    let comensal = formulario.idComensal.value;
    let tipoAtencion = formulario.tipoAtencion.value;
    console.log('comensal :>> ', comensal);
    if (tipoAtencion==="") {
      return toastPersonalizada('El tipo de atención es un campo obligatorio!', "error",3000);
    }else {
      if (tipoAtencion === "1" || tipoAtencion === "2") {
        
        if (comensal==="") 
        return toastPersonalizada('El comensal es un campo obligatorio en salidas de tipo (NORMAL, ADICIONAL)', "error");
      }
    }
    let data = new FormData(formulario);
    verLoader();
    fetch("php/atenciones/agregaGeneral.php", {
      method: "POST",
      body: data,
    })
      .then((res) => res.json())
      .then((respuesta) => {
        console.log(respuesta);
        if (respuesta[0]) {
          fetch("php/atenciones/borraSesionAlimentos.php")
            .then((res) => res.json())
            .then((json) =>
              cargarContenido(
                "php/atenciones/tablaSesionAlimento.php",
                "tablaSesionAlimentos"
              )
            );
          alertaPersonalizada(respuesta[1], "success");
          cargarContenido("php/atenciones/formAgrega.php", "contenido");
        } else {
          toastPersonalizada(respuesta[1], "error");
        }
        ocultarLoader();
      });
  } else {
    toastPersonalizada("complete todos los campos", "error");
  }
}
const obtenerTablasPorCede = (elemento) => {
  let data = new FormData();
  data.append("idCede", elemento.value);
  cargarContenidoMultiple(
    [
      fetch("php/estadisticas/tablas.php", {
        method: "POST",
        body: data,
      }),
    ],
    ["llegaTablasEstadisticas"]
  );
};

const obtenerTablasPorCedeIndex = (idCede) => {
  let data = new FormData();
  data.append("idCede", idCede);
  cargarContenidoMultiple(
    [
      fetch("php/estadisticas/principal.php", {
        method: "POST",
        body: data,
      }),
    ],
    ["contenido"]
  );
};
const generaExcel = (ruta) => {
  let id = 3;
  let descripcionArchivo = "";
  window.open(
    `${ruta}?id=${id}`,
    descripcionArchivo,
    `width=${window.innerWidth * 0.75},
      height=${window.innerHeight},
      margin=0,padding=5,scrollbars=SI,top=80,left=${left}`
  );
};
/* 
const llenarDatosComensales = (dato) => {
  let [id, nombres, dni, area, empresa] = dato.split("|");
  document.getElementById("idComensalesAct").value = id;
  document.getElementById("nombresComensalesAct").value = nombres;
  document.getElementById("dniComensalesAct").value = dni;
  document.getElementById("empresaComensalesAct").value = empresa;
  document.getElementById("areaComensalesAct").value = area;
  document.getElementById("estadoComensalesAct").value = 1;

};

const actualizaComensales = (formulario) => {
  event.preventDefault();
  if (validar_campos("formComensalesAct")) {
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
        let data = new FormData(formulario)
        fetch("php/comensales/actualiza.php", {
          method: "POST",
          body: data,
        })
          .then((res) => res.json())
          .then((respuesta) => {
            console.log(respuesta);
            $("#modalComensalesAct").modal("hide");
            (respuesta)
              ? cargarContenidoMultiple(
                  [fetch("php/comensales/tabla.php")],
                  ["tablaComensales"]
                )
              : alertaPersonalizada("Fallo Al actualizar");
            ocultarLoader();
          });
      }
    });
  } else {
    alertaCamposVacios();
  }
}; */

const obtenerDatosComensales = (elemento) => {
  let idComensal = elemento.value;
  let inputNombreNuevoComensal = document.getElementById(
    "ComensalNRegistroDiario"
  );
  inputNombreNuevoComensal.removeAttribute("data-validate");
  verLoader();
  let data = new FormData();
  data.append("idComensal", idComensal);
  fetch("php/atenciones/datosComensal.php", {
    method: "POST",
    body: data,
  })
    .then((res) => res.json())
    .then((json) => {
      console.log(json);
      document.getElementById("empresaRegistroDiario").value = json.empresa;
      document.getElementById("areaRegistroDiario").value = json.area;
      let inputComensalOtros = document.getElementById("ComensalNRegistroDiario");
      
      inputComensalOtros.setAttribute("readonly", "true");
      inputComensalOtros.value='';
      ocultarLoader();
    });
};
const guardarTipoAlimento = (elemento) => {
  (async () => {
    const { value: cantidadVal } = await Swal.fire({
      title: "Ingrese la Cantidad",
      input: "number",
      inputValue: "1",
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      confirmButtonText: "Agregar",
      inputValidator: (value) => {
        if (!value) {
          return "La cantidad es obligatoria!";
        }
      },
    });
    if (cantidadVal) {
      let idTipoAlimento = elemento.value;
      let idTipoAtencion =
        document.getElementById("formAddAtenciones").tipoAtencion.value;
      let data = new FormData();
      data.append("idTipoAlimento", idTipoAlimento);
      data.append("cantidad", cantidadVal);
      data.append("idTipoAtencion", idTipoAtencion);
      fetch("php/atenciones/sesionTipoAlimento.php", {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then((json) => {
          if (json[0]) {
            cargarContenido(
              "php/atenciones/tablaSesionAlimento.php",
              "tablaSesionAlimentos"
            );
            toastPersonalizada(json[1], "success");
          } else {
            toastPersonalizada(json[1], "error");
          }
        });
    }
  })();
};

const guardarTipoAlimentoGeneral = (elemento) => {
  let formulario = document.getElementById("formAddAtenciones");
  console.log("formulario.tipoAtencion.value", formulario.tipoAtencion.value);
  if (formulario.tipoAtencion.value === "1") {
    guardarTipoAlimentoNormal(elemento);
  } else {
    guardarTipoAlimento(elemento);
  }
};

const guardarTipoAlimentoNormal = (elemento) => {
  let idTipoAlimento = elemento.value;
  let idTipoAtencion =
    document.getElementById("formAddAtenciones").tipoAtencion.value;
  let data = new FormData();
  data.append("idTipoAlimento", idTipoAlimento);
  data.append("idTipoAtencion", idTipoAtencion);
  fetch("php/atenciones/sesionTipoAlimento.php", {
    method: "POST",
    body: data,
  })
    .then((res) => res.json())
    .then((json) => {
      console.log("json", json);
      if (json[0]) {
        cargarContenido(
          "php/atenciones/tablaSesionAlimento.php",
          "tablaSesionAlimentos"
        );
        toastPersonalizada(json[1], "success");
      } else {
        toastPersonalizada(json[1], "error");
      }
    });
};

const lecturaRegistroComensales = (formulario) => {
  event.preventDefault();
  let data = new FormData(formulario);
  fetch("php/atenciones/agregaDiario.php", {
    method: "POST",
    body: data,
  })
    .then((res) => res.json())
    .then((json) => {
      console.log("json", json);
      if (json[0]) {
        alertaPersonalizada(json[1], "success");
      } else {
        alertaPersonalizada(json[1], "error");
      }
      formulario.reset();
      let lineaLectora = document.getElementById("inputLector").focus();
    });
};
const mostrarLecturaCodigo = (elemento) => {
  let lineaLectora = document.getElementById("lineaLectora");
  lineaLectora.classList.remove("hide_lector");
  elemento.value = "";
};
const ocultarLecturaCodigo = (elemento) => {
  let lineaLectora = document.getElementById("lineaLectora");
  lineaLectora.classList.add("hide_lector");
  elemento.value = "";
};

const EliminaTipoAlimentoSesion = (indiceTipoAlimento) => {
  let data = new FormData();
  data.append("indiceTipoAlimento", indiceTipoAlimento);
  fetch("php/atenciones/eliminaTipoAlimento.php", {
    method: "POST",
    body: data,
  })
    .then((res) => res.json())
    .then((json) => {
      if (json) {
        cargarContenido(
          "php/atenciones/tablaSesionAlimento.php",
          "tablaSesionAlimentos"
        );
        toastPersonalizada("Eliminado correctamente", "success");
      } else {
        toastPersonalizada("Ocurrio algun error", "error");
      }
    });
};

const obtenerListaAlimentos = (elemento) => {
  elemento.dataset.primer_ingreso = true;
  let listaDatas = document.querySelectorAll("[data-primer_ingreso=true]");
  if (listaDatas.length > 1) {
    fetch("php/atenciones/borraSesionAlimentos.php")
      .then((res) => res.json())
      .then((json) =>
        cargarContenido(
          "php/atenciones/tablaSesionAlimento.php",
          "tablaSesionAlimentos"
        )
      );
  }
  let data = new FormData();
  data.append("idTipoVenta", elemento.value);
  cargarContenido(
    "php/atenciones/optionsAlimentos.php",
    "selectListaAlimentos",
    {
      method: "POST",
      body: data,
    }
  );
  // mostrar input fecha en caso de salidas normales
  if (elemento.value == "1") {
    let input = `<input type="date" data-validate class="form-control form-control-sm" name="fechaRegistro">`;
    document.getElementById("llegaInputFechaAdd").innerHTML=input;
  }else{ 
    document.getElementById("llegaInputFechaAdd").innerHTML='';
  }
};
const reporteExcel = () => {
  //array para enviar data de acuerdo el value del select
  event.preventDefault();
  if (!validar_campos("formReporteExcel"))
    return toastPersonalizada("Algunos Campos son necesarios");
  let arrayConfig = [
    {
      ruta: "php/generaEXCEL/reporteNormalAdicional/index.php",
      tipoAlimentos: ["tipoNormal"],
    },
    {
      ruta: "php/generaEXCEL/reporteNormalAdicional/index.php",
      tipoAlimentos: ["tipoAdicional"],
    },
    {
      ruta: "php/generaEXCEL/reporteNormalAdicional/index.php",
      tipoAlimentos: ["tipoNormal", "tipoAdicional"],
    },
    {
      ruta: "php/generaEXCEL/reporteOtros/index.php",
      tipoAlimentos: ["tipoOtros"],
    },
  ];
  let selectTipoAl = document.getElementById("tipoSalidaExcel");
  let ruta = arrayConfig[selectTipoAl.value].ruta;
  let arrayTipoAlimentos = arrayConfig[selectTipoAl.value].tipoAlimentos;
  let data = new FormData();
  let listaEnvios = "";
  arrayTipoAlimentos.forEach((e) => {
    listaEnvios += `&${e}=true`;
  });

  let formulario = document.getElementById("formReporteExcel");
  let idComensal = formulario.idComensal.value;
  let fInicio = formulario.fInicio.value;
  let fFinal = formulario.fFinal.value;
  let idEmpresa = formulario.idEmpresa.value;
  window.open(
    `${ruta}?id=${idComensal}&fInicio=${fInicio}&fFinal=${fFinal}&idEmpresa=${idEmpresa}${listaEnvios}`,
    "facturacion"
  );
};

const EliminaListaSesionProductos = (title, cambioTipoAtencion) => {
  Swal.fire({
    title: title,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "si",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      verLoader();
      fetch("php/atenciones/borraSesionAlimentos.php")
        .then((res) => res.json())
        .then((json) => {
          if (json[0]) {
            toastPersonalizada(json[1], "success");
            cargarContenido(
              "php/atenciones/tablaSesionAlimento.php",
              "tablaSesionAlimentos"
            );
          } else {
            toastPersonalizada(json[1], "warning");
          }
          ocultarLoader();
        });
    } else {
      if (cambioTipoAtencion) {
        document.getElementById;
      }
    }
  });
};

const limitarFechaUnMes = (elemento) => {
  var DateHelper = {
    addDays: function (aDate, numberOfDays) {
      aDate.setDate(aDate.getDate() + numberOfDays); // Add numberOfDays
      return aDate; // Return the date
    },
    format: function format(date) {
      return [
        date.getFullYear(), // Get full year
        ("0" + (date.getMonth() + 1)).slice(-2), // Get month and pad it with zeroes
        ("0" + date.getDate()).slice(-2), // Get day and pad it with zeroes
      ].join("-"); // Glue the pieces together
    },
  };
  let fechaInicio = elemento.value;
  let inputFechaFinal = document.getElementById("fFinalReporteExcel");
  inputFechaFinal.setAttribute(
    "max",
    DateHelper.format(DateHelper.addDays(new Date(fechaInicio), 31))
  );
};
const asignarUrlGeneraExcel = (elemento) => {
  let url = elemento.value;
  let buttonEnviar = document.getElementById("buttonGeneraExcel");
  buttonEnviar.dataset.url_excel = url;
};

const verDetalleSalidas = (idRegistroAlimentacion) => {
  let data = new FormData();
  data.append("idRegistroAlimentacion",idRegistroAlimentacion)
  cargarContenido("php/atenciones/detalleAdicionalOtros.php","llegaDetalleAdicionalOtros",{
    method:"post",
    body:data
  })
}
