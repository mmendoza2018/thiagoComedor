/* muestra el loader cuando la pagina esta cargada por completo */
window.addEventListener("load", () => {
  ocultarLoader();

  //muestra monitor de alertas 
  setTimeout(() => {
    let elementoSesionPhp = document.getElementById("estadoIngresoSistema")
    if (elementoSesionPhp.dataset.estado_sis ==="1") {
      let rutaActual = localStorage.getItem("rutaTh");
      let vistaMonitor = "php/recursosHumanos/documentos/tablaMonitor.php";
      if (rutaActual !== vistaMonitor) {
        $("#modalVerTablaMonitor").modal("show")
      }
      cargarContenido("php/recursosHumanos/documentos/tablaMonitor.php","llegaTablaALertaDocs")
    }
  }, 1000);

});

document.addEventListener("DOMContentLoaded", () => {
  MostrarRutaStorage();
  $("#modales").load("componentes/modales.php");
  validar_campos();
  CambiarIconoSidebar();
  validaNumerosPositivos();
  routerVistas("#listaPersonas", "php/ordenes/lista_personas.php");
  routerVistas("#btnFormComensales", "php/comensales/principal.php");
  routerVistas("#btnRegistroVentas", "php/atenciones/formAgrega.php");
  routerVistas("#btnlistadoVentasNormal", "php/atenciones/tablaNormal.php");
  routerVistas(
    "#btnlistadoVentasAdicional",
    "php/atenciones/tablaAdicional.php"
  );
  routerVistas("#btnlistadoVentasOtros", "php/atenciones/tablaOtros.php");

  routerVistas("#btnEstadisticas", "php/estadisticas/principal.php");
  routerVistas(
    "#btnEstadisticasEmpresas",
    "php/estadisticas/atencionesEmpresas.php"
  );

  routerVistas("#btnlectorQr", "php/atenciones/lectorQr.php");
  routerVistas("#btnTeclado", "php/atenciones/formTeclado.php");
  routerVistas("#btnPrueba", "php/atenciones/prueba.php");
  routerVistas("#btnReportes", "php/atenciones/formReportes.php");
  /* recursos humanos */
  routerVistas(
    "#sidebarNuevoPersonal",
    "php/recursosHumanos/personal/index.php"
  );
  routerVistas(
    "#sidebarGestionPersonal",
    "php/recursosHumanos/personal/tabla.php"
  );
  routerVistas(
    "#sidebarNuevoDocumento",
    "php/recursosHumanos/documentos/index.php"
  );
  routerVistas(
    "#sidebarGestionDocumento",
    "php/recursosHumanos/documentos/tabla.php"
  );
  routerVistas(
    "#sidebarMonitorAlertas",
    "php/recursosHumanos/documentos/tablaMonitor.php"
  );

  routerVistas(
    "#sidebarEnviosDocumento",
    "php/recursosHumanos/documentos/envioDocumentos.php"
  );

  /* mantenimientos */
  routerVistas("#btnFormComedores", "php/mantenimientos/comedores/index.php");
  routerVistas("#btnFormEmpresas", "php/mantenimientos/empresas/index.php");
  routerVistas("#btnFormHorarios", "php/mantenimientos/horarios/index.php");
  routerVistas(
    "#btntipoAlimentos",
    "php/mantenimientos/tipoAlimentos/index.php"
  );
  routerVistas(
    "#btntipoAtenciones",
    "php/mantenimientos/tipoAtenciones/index.php"
  );
  routerVistas(
    "#btntipoRegistros",
    "php/mantenimientos/tipoRegistros/index.php"
  );
  routerVistas("#btnCargos", "php/mantenimientos/cargos/index.php");
  routerVistas("#btnTiposDocumento", "php/mantenimientos/tipoDocumento/index.php");
});

/* funcion para validar los campos  */
function validar_campos(idForm) {
  let data = document.querySelectorAll(`#${idForm} [data-validate]`);
  let validacion = true;
  if (data.length > 0) {
    for (let i = 0; i < data.length; i++) {
      if (
        data[i].getAttribute("type") === "text" &&
        data[i].value.match(/^[0-9]$/)
      ) {
        validacion = false;
        data[i].style.setProperty("border", "1px solid red");
        setTimeout(() => {
          data[i].style.setProperty("border", "");
        }, 2000);
      }
      if (
        data[i].getAttribute("type") === "number" &&
        data[i].value.match(/^[0-9]$/) === "false"
      ) {
        data[i].style.setProperty("border", "1px solid red");
        validacion = false;
        setTimeout(() => {
          data[i].style.setProperty("border", "");
        }, 2000);
      }
      if (data[i].value === "" || data[i].value === null) {
        data[i].style.setProperty("border", "1px solid red");
        validacion = false;
        setTimeout(() => {
          data[i].style.setProperty("border", "");
        }, 2000);
      }
    }
  }
  return validacion;
}
/* alerta campos vacios */
const toastPersonalizada = (
  mensaje = "Ocurrio algun error",
  tipoAlerta = "success",
  tiempo = "2000"
) => {
  const Toast = Swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  });

  Toast.fire({
    icon: tipoAlerta,
    title: mensaje,
  });
};

const alertaPersonalizada = (
  mensaje = "Ocurrio algun error",
  tipoAlerta = "success",
  tiempo = "1500"
) => {
  Swal.fire({
    position: "center",
    icon: tipoAlerta,
    title: mensaje,
    showConfirmButton: false,
    timer: tiempo,
  });
};

/* funcion para ocultar el loader de carga */
function ocultarLoader() {
  let loader = document.querySelector(".loader-page");
  loader.style.setProperty("visibility", "hidden");
  loader.style.setProperty("opacity", 0);
}

/* funcion para mostrar otro icono cuando se acorta en sidebar */
function CambiarIconoSidebar() {
  let pWGeneral = document.getElementById("PW_general");
}

/* funcion para mostrar el loader de carga */
function verLoader() {
  let loader = document.querySelector(".loader-page");
  loader.style = "";
}
/* funcion para mostrar el loader de carga */
/* function guardarDireccion() {
  if (localStorage.getItem("ruta")) {
    $("#contenido").load(localStorage.getItem("ruta"))
  }
} */
/* funcion para cargar contendio via ajax  */
function routerVistas(idBoton, url) {
  document.addEventListener("click", (e) => {
    if (e.target.matches(idBoton)) {
      verLoader();
      $.ajax({
        url: url,
        success: function (response) {
          /* document.getElementById(contenedor).innerHTML=response; */
          $("#contenido").html(response);
          localStorage.setItem("rutaTh", url);
          ocultarLoader();
        },
      });
    }
  });
}
const cargarContenidoMultiple = (promesas, arrayIdElementoLlegada) => {
  /* En el parametro promesas se envia las promesas y el segundo parametro se envia donde se pintara las respuestas de las peticiones  */
  verLoader();
  Promise.all(promesas.map((prom) => prom.then((res) => res.text()))).then(
    (resultado) => {
      for (let x = 0; x < resultado.length; x++) {
        /* document.getElementById(arrayIdElementoLlegada[x]).innerHTML= resultado[x] */
        $("#" + arrayIdElementoLlegada[x]).html(resultado[x]);
      }
      ocultarLoader();
    }
  );
};

const cargarContenido = (ruta, idLlegada, options = {}, mostrarRes = false) => {
  fetch(ruta, options)
    .then((res) => res.text())
    .then((html) => {
      $(`#${idLlegada}`).html(html);
      if (mostrarRes) console.log("html", html);
    });
};

const obteneridElSeleccionado = (idFormulario, classInput) => {
  //la clase del input formulario debe ser igual al value del list
  let valueSelect = document
    .getElementById(idFormulario)
    .querySelector(`.${classInput}`).value;
  let options = document.querySelectorAll(`#${classInput} option`);
  let idFinal = "";
  options.forEach((e) => {
    // console.log(e.textContent+"--"+valueSelect);
    if (e.textContent.replace(/\s+/g, "") === valueSelect.replace(/\s+/g, ""))
      idFinal = e.dataset.value;
  });
  return idFinal;
};

const limpiarFormulario = (idFormulario) => {
  document.getElementById(idFormulario).reset();
};

/* funcion para esperar confirmacion al realizar una accion */
function confirmacion() {
  Swal.fire({
    target: document.getElementById("modal_act_prestamo"),
    title: "¿Estas seguro de actualizar?",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "si",
    cancelButtonText: "Cancelar",
  }).then((result) => result.isConfirmed);
}

//para resetear el formulario
const validaRespuestasAgregar = (respuesta, ruta, idFormulario = false) => {
  if (respuesta) {
    Swal.fire({
      position: "center",
      icon: "success",
      title: "Agregado con exito!",
      showConfirmButton: false,
      timer: 1500,
    });
    $("#contenido").load(ruta);
    if (idFormulario !== false) {
      $("#contenido").load(ruta);
      document.getElementById(idFormulario).reset();
    }
  } else {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Fallo al agregar!",
      showConfirmButton: false,
      timer: 1500,
    });
  }
};

/* funcion para mostrar alertas de acuerdo a la respuesta, recibe dos parametros una la respuesta y la otra la ruta 
para resetear el formulario */
const validaRespuestaActualizar = (respuesta, ruta, idmodal) => {
  if (respuesta) {
    Swal.fire({
      position: "center",
      icon: "success",
      title: "Actualizado con exito!",
      showConfirmButton: false,
      timer: 1500,
    });
    $("#contenido").load(ruta);
    $("#" + idmodal).modal("hide");
  } else {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Fallo al Actualizar!",
      showConfirmButton: false,
      timer: 1500,
    });
  }
};
const validaNumerosPositivos = () => {
  document.addEventListener("keyup", (e) => {
    if (e.target.matches(`input[type="number"]`)) {
      let valor = e.target.value;
      if (Math.sign(valor) === -1) {
        e.target.style.setProperty("border", "1px solid red");
        setTimeout(() => {
          e.target.value = "";
          e.target.style.setProperty("border", "");
        }, 2000);
      }
    }
  });
};
function MostrarRutaStorage() {
  let rutaActual = localStorage.getItem("rutaTh");
  if (rutaActual) {
    let primerIngresoSistema = document.getElementById("estadoIngresoSistema")
      .dataset.estado_sis;
    primerIngresoSistema == "1"
      ? $("#contenido").load("php/home/index.php")
      : $("#contenido").load(localStorage.getItem("rutaTh"));
  }
}

document.addEventListener("input", (e) => {
  if (e.target.matches("input[type=text]")) {
    e.target.value = e.target.value.toUpperCase();
  }
});

const clonarElemento = (idElemento, valor = "") => {
  let elemento = document.getElementById(idElemento);
  let clone = elemento.cloneNode(true);
  clone.querySelectorAll("input").forEach((e) => (e.value = valor));
  elemento.parentElement.insertAdjacentElement("beforeend", clone);
};
const QuitarElemento = (elemento) => {
  let cloneElement = elemento.parentElement.parentElement.parentElement;
  let numeroInputs =
    cloneElement.parentElement.querySelectorAll(".row[data-clone]");
  //console.log(cloneElement, numeroInputs);
  if (numeroInputs.length > 1) {
    cloneElement.remove();
  }
};

//obtener lugares
const selectChange = (elemento, ruta, idLlegada) => {
  let data = new FormData();
  data.append("idSelect", elemento.value);
  fetch(ruta, {
    method: "POST",
    body: data,
  })
    .then((res) => res.text())
    .then((options) => {
      document.getElementById(idLlegada).innerHTML = options;
      ocultarLoader();
    });
};

const generaPdf = (ruta, descripcion = "Reporte") => {

  var left = screen.width / 2 - (window.innerWidth * 0.75) / 2;

    window.open(
      `${ruta}`,
      `${descripcion}`,
      `width=${window.innerWidth * 0.75},height=${
        window.innerHeight
      },margin=0,padding=5,scrollbars=SI,top=80,left=${left}`
    );

};

/*  envio documentos multiples */

// ejecuta cada ves que alguien hace check en un registro
const capturarIddocEquipoMultiple = (elemento) => {
  const d = document;
  let checked = elemento.checked;
  let objetoTemporal = {
      id: elemento.dataset.check,
      codigo: elemento.dataset.codigo,
      documento: elemento.dataset.documento,
  };
  let arrayFinal = [];
  if (localStorage.getItem("docPerThMulti")) {
      if(!checked) return removeRegistroParcial(objetoTemporal.id);
    let dataLocalStorage = JSON.parse(localStorage.getItem("docPerThMulti"));
    dataLocalStorage.push(objetoTemporal);
    localStorage.setItem("docPerThMulti", JSON.stringify(dataLocalStorage));
  } else {
    arrayFinal.push(objetoTemporal);
    localStorage.setItem("docPerThMulti", JSON.stringify(arrayFinal));
  }
};

//abre el modal y muestra los archivos a enviar
const modalEnvioDocumentosMulti = () => {
  let dataLocalStorage = localStorage.getItem("docPerThMulti");
  if (!dataLocalStorage) return toastPersonalizada('marca al menos un documento','warning');
  verListaRegistroParcial();
  $("#modalEnviarAdjuntoMulti").modal("show");
}

//muestra todos los documentos seleccionados
const verListaRegistroParcial = () => {
  let dataLocalStorage = localStorage.getItem("docPerThMulti");
  let tBody = document.getElementById('llegadaListaDocumentosMulti');
  if (!dataLocalStorage) return toastPersonalizada('marca al menos un documento','warning');
  let html = "";
  dataLocalStorage = JSON.parse(dataLocalStorage);
  let arregloOrdenado = groupByKey(dataLocalStorage,'codigo');
  for (const x in arregloOrdenado) {
      html += `<div class='col-sm-3 p-2'>
      <div class='shadow bg-secondary-opacity-2 p-1'>
                  <b class='text-center d-block'>${x}</b>
                  <ul class="mb-1">`;
      arregloOrdenado[x].forEach(e => {
                    html += `<li>${e.documento}</li>`
                });
          html += `</ul> 
          </div> </div>`;
  }
  tBody.innerHTML = html;
  
};

//envia todos los archivos al back
const  enviarDocEquipoMulti = () => {
  let dataLocalStorage = localStorage.getItem("docPerThMulti");
  if (dataLocalStorage ){
      if (dataLocalStorage.length===0) return toastPersonalizada("marca al menos un documento",'warning')
  }else {
      return toastPersonalizada("marca al menos un documento",'warning');
  }
  dataLocalStorage = JSON.parse(dataLocalStorage);
  let arregloOrdenado = groupByKey(dataLocalStorage,'codigo');
  
  let valorCorreo = document.getElementById("correodocsMulti").value,
  asuntoCorreo = document.getElementById("asuntodocsMulti").value,
  regexsCorreo = valorCorreo.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/);
  if (regexsCorreo === null) return alertaPersonalizada("Ingrese un correo valido", "error");
  if (asuntoCorreo == "") {
    asuntoCorreo="-";
  }
  verLoader()

  let data = new FormData();
  data.append("docsEquipos", JSON.stringify(arregloOrdenado)) 
  data.append("correo", valorCorreo) 
  data.append("asunto", asuntoCorreo) 
  fetch("php/envioPDF/documentoPersonalMulti/envio.php", {
      method:"POST",
      body:data
  })
  .then(res => res.json())
  .then(json =>  {
      if (json) {
          alertaPersonalizada('Correo enviado','success',1500)
          removeDataLSDocMulti();
          cargarContenido("php/recursosHumanos/documentos/envioDocumentos.php", "contenido")
          $("#modalEnviarAdjuntoMulti").modal("hide");
      }else {
          alertaPersonalizada('Fallo al enviar el correo!','error',1500)
      }
      ocultarLoader();
  })
}

//quita un elemento cuando quitan el check a un registro
const removeRegistroParcial = (idCheck) => {
  let newData = [];
  let data = JSON.parse(localStorage.getItem("docPerThMulti"));
  for (let i of data) {
    if (i.id===idCheck) {
      continue;
    } else {
      newData.push(i);
    }
  }
  localStorage.setItem("docPerThMulti", JSON.stringify(newData));
 // verListaRegistroParcial(element.dataset.tbody);
};

//limpia la data al enviar los archivos
const removeDataLSDocMulti = () => {
    if (localStorage.getItem('docPerThMulti')) {
        localStorage.removeItem('docPerThMulti');
    }
};



/*  fin envio documentos multiples */

function groupByKey(array, key) {
  return array
    .reduce((hash, obj) => {
      if(obj[key] === undefined) return hash; 
      return Object.assign(hash, { [obj[key]]:( hash[obj[key]] || [] ).concat(obj)})
    }, {})
}

const limitarTextoInput = ( elemento, min = false, max) => {
  console.log("fdsf");
  let valueInput = elemento.value;
  let valido = true;
  if ( min ) {
     if ( valueInput.length < min ) return toastPersonalizada(`el minimo de caracteres es ${ min }`, "warning");
    }
  if ( valueInput.length > max ){
    elemento.value = valueInput.slice(0, -1);
    return toastPersonalizada(`el maximo de caracteres es ${ max }`, "warning");
  }
} 