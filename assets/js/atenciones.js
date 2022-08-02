function agregarAtenciones  () {
  event.preventDefault();
  if (validar_campos("formAddAtenciones")) {
    let formulario = document.getElementById("formAddAtenciones");
    let data = new FormData(formulario);
    verLoader();
    fetch("php/atenciones/agregaGeneral.php", {
      method: "POST",
      body: data,
    })
      .then((res) => res.json())
      .then((respuesta) => {
        console.log(respuesta);
        if (respuesta[0]){
          alertaPersonalizada(respuesta[1],"success");
          cargarContenido('php/atenciones/formAgrega.php','contenido');
        }else{
          alertaPersonalizada(respuesta[1],"error");
        }
        ocultarLoader();
      });
  } else {
    alertaPersonalizada("complete todos los campos", "error");
  }
}
const obtenerTablasPorCede = (elemento) => {
  let data = new FormData();
    data.append("idCede",elemento.value)
  cargarContenidoMultiple(
    [fetch("php/estadisticas/tablas.php",{
      method:"POST",
      body:data
    })], 
    ["llegaTablasEstadisticas"]
  );
};

const obtenerTablasPorCedeIndex = (idCede) => {
  let data = new FormData();
    data.append("idCede",idCede)
  cargarContenidoMultiple(
    [fetch("php/estadisticas/principal.php",{
      method:"POST",
      body:data
    })], 
    ["contenido"]
  );
};
const generaExcel = (ruta) => {
  let id=3;
  let descripcionArchivo =''
    window.open(
      `${ruta}?id=${id}`,
      descripcionArchivo,
      `width=${window.innerWidth * 0.75},
      height=${ window.innerHeight},
      margin=0,padding=5,scrollbars=SI,top=80,left=${left}`
    );
}
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
    verLoader()
    let data = new FormData();
    data.append("idComensal",idComensal)
    fetch("php/atenciones/datosComensal.php",{
      method:"POST",
      body:data
    })
    .then(res => res.json())
    .then(json => { 
      console.log(json);
        document.getElementById("empresaRegistroDiario").value=json.empresa
        document.getElementById("areaRegistroDiario").value=json.area
        document.getElementById("ComensalNRegistroDiario").setAttribute("readonly","true")
        ocultarLoader();
    })
}
const guardarTipoAlimento = (elemento) => {
  let idTipoAlimento = elemento.value;
  let data = new FormData();
  data.append('idTipoAlimento',idTipoAlimento)
  fetch('php/atenciones/sesionTipoAlimento.php', {
    method:"POST",
    body:data,
  })
  .then(res => res.json())
  .then(json => {
    if (json) {
      cargarContenido('php/atenciones/tablaSesionAlimento.php','tablaSesionAlimentos');
      toastPersonalizada('Agregado con exito!','success')
    }else{
      toastPersonalizada('Ocurrio algun error!','error')
    }
  })
}

const lecturaRegistroComensales = (formulario) => {
  event.preventDefault();
  let data = new FormData(formulario)
  fetch('php/atenciones/agregaDiario.php', {
    method:"POST",
    body:data,
  })
  .then(res => res.json())
  .then(json => {
    console.log('json', json)
    if (json[0]) {
      toastPersonalizada(json[1],'success');
    }else {
      alertaPersonalizada(json[1],'error');
    }
    formulario.reset();
    let lineaLectora = document.getElementById("inputLector").focus();
  })
}
const mostrarLecturaCodigo = (elemento) => {
  let lineaLectora = document.getElementById("lineaLectora");
  lineaLectora.classList.remove("hide_lector")
  elemento.value='';
}
const ocultarLecturaCodigo = (elemento) => {
  let lineaLectora = document.getElementById("lineaLectora");
  lineaLectora.classList.add("hide_lector")
  elemento.value='';
}

const EliminaTipoAlimentoSesion = (indiceTipoAlimento) => {
  Swal.fire({
    title: "¿Esta seguro de quitar este producto?",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "si",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      let data = new FormData();
      data.append("indiceTipoAlimento", indiceTipoAlimento);
      fetch('php/atenciones/eliminaTipoAlimento.php', {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then((json) => {
          if (json) {
            cargarContenido('php/atenciones/tablaSesionAlimento.php','tablaSesionAlimentos');
            toastPersonalizada("Eliminado correctamente", "success");
          }else {
            toastPersonalizada('Ocurrio algun error','error');
          }
        });
    }
  });
};

const obtenerListaAlimentos = (elemento) => {
  let data = new FormData();
  data.append('idTipoVenta',elemento.value)
  cargarContenido('php/atenciones/optionsAlimentos.php','selectListaAlimentos',{
    method:'POST',
    body:data
  },true)
}
const reporteExcel = () => {
  event.preventDefault();
  let formulario = document.getElementById("formReporteExcel");
  let idComensal = formulario.idComensal.value;
  let fInicio = formulario.fInicio.value;
  let fFinal = formulario.fFinal.value;
  let ruta = 'php/generaEXCEL/reporteNormal/index.php'
    window.open(
      `${ruta}?id=${idComensal}&fInicio=${fInicio}&fFinal=${fFinal}`,
      "facturacion",
    );
}
