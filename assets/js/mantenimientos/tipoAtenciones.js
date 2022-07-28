function agregarTipoAtencion() {
    event.preventDefault();
    console.log(event);
    if (validar_campos("formTipoAtencion")) {
        verLoader()
        $.ajax({
            type: "POST",
            url: "php/mantenimientos/tipoAtenciones/agrega.php",
            data: $("#formTipoAtencion").serialize(),
            success: function (response) {
                validaRespuestasAgregar(response, "php/mantenimientos/tipoAtenciones/index.php")
                ocultarLoader();
            }
        });
    } else {
        toastPersonalizada("Datos Incompletos","error")
    }
}

const llenarDatosTipoAtencion = (dato) => {
    let x = dato.split("|");
    document.getElementById("TIAT_id").value = x[0];
    document.getElementById("TIAT_descripcion").value = x[1];
    document.getElementById("TIAT_estado").value = x[2];
}

const actualizaTipoAtencion = () => {
    if (validar_campos("formTipoAtencionAct")) {
        Swal.fire({
            title: '¿Estas seguro de actualizar?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                verLoader();
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "php/mantenimientos/tipoAtenciones/actualiza.php",
                    data: $("#formTipoAtencionAct").serialize(),
                    success: function (response) {
                        validaRespuestaActualizar(response, "php/mantenimientos/tipoAtenciones/index.php", "modalTipoAtencionAct")
                        ocultarLoader();
                    }
                });
            }
        })
    }else{
        toastPersonalizada("Falta Datos","error")
    }
  }