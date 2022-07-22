async function agregarAtenciones  (formulario) {
  event.preventDefault();
  let Comensal = await obteneridElSeleccionado("formAddAtenciones","dataComensalesAtenciones")
    if (Comensal===""){
      alert("Comensal No valido");
      document.getElementById("empresaRegistroDiario").value="";
      document.getElementById("areaRegistroDiario").value="";
      return
    } 
  if (validar_campos("formAddAtenciones")) {
    let data = new FormData(formulario);
    data.append("idComensal",Comensal)
    verLoader();
    fetch("php/atenciones/agrega.php", {
      method: "POST",
      body: data,
    })
      .then((res) => res.text())
      .then((respuesta) => {
        console.log(respuesta);
        if (respuesta){
          cargarContenidoMultiple(
            [fetch("php/atenciones/principal.php")],
            ["contenido"]
          )
          alertaPersonalizada("Agregado con exito","success");
        }else{
          alertaPersonalizada("Fallo Al agregar","error");
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
  fetch('php/atenciones/agrega.php', {
    method:"POST",
    body:data,
  })
  .then(res => res.json())
  .then(json => {
    console.log('json', json)
    if (json) {
      toastPersonalizada('Comensal registrado','success');
    }else {
      toastPersonalizada('Ocurrio algun error','error');
    }
    formulario.reset();
    let lineaLectora = document.getElementById("inputLector").focus();
  })
}
const mostrarLecturaCodigo = () => {
  let lineaLectora = document.getElementById("lineaLectora");
  lineaLectora.classList.remove("hide_lector")
}
const ocultarLecturaCodigo = () => {
  let lineaLectora = document.getElementById("lineaLectora");
  lineaLectora.classList.add("hide_lector")
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
            alerta_personalizada("Eliminado correctamente", "success");
          }else {
            toastPersonalizada('Ocurrio algun error','error');
          }
        });
    }
  });
};
