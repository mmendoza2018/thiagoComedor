function agregarComensales(formulario) {
  event.preventDefault();
  if (validar_campos("formAddComensales")) {
    let data = new FormData(formulario);
    verLoader();
    fetch("php/comensales/agrega.php", {
      method: "POST",
      body: data,
    })
      .then((res) => res.json())
      .then((respuesta) => {
        if (respuesta) {
          cargarContenidoMultiple(
            [fetch("php/comensales/principal.php")],
            ["contenido"]
          );
          alertaPersonalizada("Agregado con exito", "success");
        } else {
          alertaPersonalizada("Fallo Al agregar", "error");
        }
        ocultarLoader();
      });
  } else {
    toastPersonalizada("complete todos los campos", "error");
  }
}
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
        let data = new FormData(formulario);
        fetch("php/comensales/actualiza.php", {
          method: "POST",
          body: data,
        })
          .then((res) => res.json())
          .then((respuesta) => {
            $("#modalComensalesAct").modal("hide");
            if (respuesta) {
              cargarContenidoMultiple(
                [fetch("php/comensales/tabla.php")],
                ["tablaComensales"]
              );
              alertaPersonalizada("Actualizado con exito", "success");
            } else {
              alertaPersonalizada("Fallo Al actualizar", "error");
            }
            ocultarLoader();
          });
      }
    });
  } else {
    toastPersonalizada("Algunos campos son obligatorios","error");
  }
};

const importarComensalesExcel = () => {
  let formulario = document.getElementById("formImportarExcel");
  let data = new FormData(formulario);
  if (!validar_campos("formImportarExcel"))
    return toastPersonalizada("algunos campos son obligatorios", "warning");
  verLoader();
  fetch("php/comensales/lecturaExcel.php", {
    method: "POST",
    body: data,
  })
    .then((res) => res.json())
    .then((json) => {
      if (json[0]) {
        alertaPersonalizada("Importacion Exitosa!", "success");
        $("#modalConfirmImportExcel").modal("hide")
      } else {
        alertaPersonalizada(json[1],json[2] , 4000);
      }
      formulario.reset();
      ocultarLoader();
    });
};
