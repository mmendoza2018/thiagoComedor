/* muestra el loader cuando la pagina esta cargada por completo */
window.addEventListener("load", ()=>{
  ocultarLoader()
})

document.addEventListener("DOMContentLoaded", () => {


  MostrarRutaStorage()
  $("#modales").load("componentes/modales.php")
  validar_campos();
  CambiarIconoSidebar();
  validaNumerosPositivos();
  routerVistas("#listaPersonas","php/ordenes/lista_personas.php")
  routerVistas("#btnFormComensales","php/comensales/principal.php")
  routerVistas("#btnRegistroVentas","php/atenciones/formAgrega.php")
  routerVistas("#btnlistadoVentasNormal","php/atenciones/tablaNormal.php")
  routerVistas("#btnlistadoVentasAdicional","php/atenciones/tablaAdicional.php")
  routerVistas("#btnlistadoVentasOtros","php/atenciones/tablaOtros.php")

  routerVistas("#btnEstadisticas","php/estadisticas/principal.php")
  routerVistas("#btnlectorQr","php/atenciones/lectorQr.php")
  routerVistas("#btnPrueba","php/atenciones/prueba.php")
  routerVistas("#btnReportes","php/atenciones/formReportes.php")
  
  /* mantenimientos */
  routerVistas("#btnFormComedores","php/mantenimientos/comedores/index.php")
  routerVistas("#btnFormEmpresas","php/mantenimientos/empresas/index.php")
  routerVistas("#btnFormHorarios","php/mantenimientos/horarios/index.php")
  routerVistas("#btntipoAlimentos","php/mantenimientos/tipoAlimentos/index.php")
  routerVistas("#btntipoAtenciones","php/mantenimientos/tipoAtenciones/index.php")  
  routerVistas("#btntipoRegistros","php/mantenimientos/tipoRegistros/index.php")
  
  
  

})

/* funcion para validar los campos  */
function validar_campos(idForm) {
    let data = document.querySelectorAll(`#${idForm} [data-validate]`)
    let validacion = true;
    if (data.length > 0) {
      for (let i = 0; i < data.length; i++) {
          if (data[i].getAttribute("type")==="text" && data[i].value.match(/^[0-9]$/)){
            validacion = false;
            data[i].style.setProperty("border","1px solid red")
            setTimeout(() => {
                data[i].style.setProperty("border","") 
            }, 2000);
          }
          if (data[i].getAttribute("type")==="number" && (data[i].value.match(/^[0-9]$/))==="false"){
            data[i].style.setProperty("border","1px solid red")
            validacion = false;
            setTimeout(() => {
                data[i].style.setProperty("border","") 
            }, 2000);
          }
        if (data[i].value === '' || data[i].value === null) {
            data[i].style.setProperty("border","1px solid red")
            validacion = false;
            setTimeout(() => {
                data[i].style.setProperty("border","") 
            }, 2000);
        }
      }
    }
    return validacion;
  }
  /* alerta campos vacios */
  const toastPersonalizada = (mensaje="Ocurrio algun error",tipoAlerta="success",tiempo="2000") => {
    const Toast = Swal.mixin({
      toast: true,
      position: 'bottom-end',
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })
  
    Toast.fire({
      icon: tipoAlerta,
      title: mensaje
    })
  }

  const alertaPersonalizada = (mensaje="Ocurrio algun error",tipoAlerta="success",tiempo="1500") => {
    Swal.fire({
      position: 'center',
      icon: tipoAlerta,
      title: mensaje,
      showConfirmButton: false,
      timer: tiempo
    })
  }


/* funcion para ocultar el loader de carga */
function ocultarLoader() {
  let loader = document.querySelector(".loader-page");
  loader.style.setProperty("visibility","hidden")
  loader.style.setProperty("opacity",0)
}

/* funcion para mostrar otro icono cuando se acorta en sidebar */
function CambiarIconoSidebar() {
  let pWGeneral = document.getElementById("PW_general");
}

/* funcion para mostrar el loader de carga */
function verLoader() {
  let loader = document.querySelector(".loader-page");
  loader.style="";
}
/* funcion para mostrar el loader de carga */
/* function guardarDireccion() {
  if (localStorage.getItem("ruta")) {
    $("#contenido").load(localStorage.getItem("ruta"))
  }
} */
  /* funcion para cargar contendio via ajax  */
function routerVistas(idBoton,url) {
    document.addEventListener("click", (e) => {
      if (e.target.matches(idBoton)) {
        verLoader()
        $.ajax({
          url: url,
          success: function (response) {
              /* document.getElementById(contenedor).innerHTML=response; */
              $("#contenido").html(response)
              localStorage.setItem("rutaTh", url);
              ocultarLoader();
          }
        });
      }
    })
}
const cargarContenidoMultiple = (promesas,arrayIdElementoLlegada) => {
  /* En el parametro promesas se envia las promesas y el segundo parametro se envia donde se pintara las respuestas de las peticiones  */
  verLoader();
  Promise.all(promesas.map(prom => prom.then(res => res.text())))
  .then(resultado => {
    for (let x = 0; x < resultado.length; x++) {
      /* document.getElementById(arrayIdElementoLlegada[x]).innerHTML= resultado[x] */
      $("#"+arrayIdElementoLlegada[x]).html(resultado[x])
    }
  ocultarLoader();
})
}

const cargarContenido = (ruta, idLlegada, options={},mostrarRes=false) => {
  fetch(ruta, options)
  .then(res => res.text())
  .then(html => {
    $(`#${idLlegada}`).html(html)
    if(mostrarRes) console.log('html', html)
  })
}

const obteneridElSeleccionado = (idFormulario, classInput) => {
  //la clase del input formulario debe ser igual al value del list
 let valueSelect = document.getElementById(idFormulario).querySelector(`.${classInput}`).value;
 let options = document.querySelectorAll(`#${classInput} option`);
 let idFinal="";
 options.forEach(e => {
    // console.log(e.textContent+"--"+valueSelect);
     if ((e.textContent.replace(/\s+/g, ''))===(valueSelect.replace(/\s+/g, ''))) idFinal= e.dataset.value;
 });
 return idFinal;
}

const limpiarFormulario = (idFormulario) => {
  document.getElementById(idFormulario).reset();
}

/* funcion para esperar confirmacion al realizar una accion */
function confirmacion () {
  Swal.fire({
    target: document.getElementById('modal_act_prestamo'),
    title: '¿Estas seguro de actualizar?',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'si',
    cancelButtonText: 'Cancelar'
  }).then((result) => result.isConfirmed)
}


//para resetear el formulario
const validaRespuestasAgregar = (respuesta, ruta,idFormulario=false) => {
  if (respuesta) {
    $("#contenido").load(ruta)
    if (idFormulario!==false) {
      $("#contenido").load(ruta)
      document.getElementById(idFormulario).reset();
    }
  } else {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Fallo al agregar!',
      showConfirmButton: false,
      timer: 1500
    })
  }
}

/* funcion para mostrar alertas de acuerdo a la respuesta, recibe dos parametros una la respuesta y la otra la ruta 
para resetear el formulario */
const validaRespuestaActualizar = (respuesta, ruta, idmodal) => {
  if (respuesta) {
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Actualizado con exito!',
      showConfirmButton: false,
      timer: 1500
    })
    $("#contenido").load(ruta);
    $("#" + idmodal).modal("hide");
  } else {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Fallo al Actualizar!',
      showConfirmButton: false,
      timer: 1500
    })
  }
}
 const validaNumerosPositivos = () => {
   document.addEventListener("keyup", (e) => {
     if (e.target.matches(`input[type="number"]`)) {
        let valor = e.target.value;
        if (Math.sign(valor)===-1) {
            e.target.style.setProperty("border","1px solid red")
            setTimeout(() => {
              e.target.value="";
              e.target.style.setProperty("border","") 
            }, 2000);
        }
     }
   })
 }
function MostrarRutaStorage() {
  let rutaActual = localStorage.getItem("rutaTh");
  if (rutaActual) {
    let primerIngresoSistema = document.getElementById("estadoIngresoSistema").dataset.estado_sis;
    (primerIngresoSistema =="1") 
     ? $("#contenido").load("php/home/index.php")
     : $("#contenido").load(localStorage.getItem("rutaTh"));
  }
}


