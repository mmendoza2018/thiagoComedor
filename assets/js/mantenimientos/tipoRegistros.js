function agregarTipoRegistro() {
    event.preventDefault();
    console.log(event);
    if (validar_campos("formTipoRegistro")) {
        verLoader()
        $.ajax({
            type: "POST",
            url: "php/mantenimientos/tipoRegistros/agrega.php",
            data: $("#formTipoRegistro").serialize(),
            success: function (response) {
                validaRespuestasAgregar(response, "php/mantenimientos/tipoRegistros/index.php")
                ocultarLoader();
            }
        });
    } else {
        toastPersonalizada("Datos Incompletos","error")
    }
}

const llenarDatosTipoRegistro = (dato) => {
    let x = dato.split("|");
    document.getElementById("TIRE_id").value = x[0];
    document.getElementById("TIRE_descripcion").value = x[1];
    document.getElementById("TIRE_estado").value = x[2];
}

const actualizaTipoRegistro = () => {
    if (validar_campos("formTipoRegistroAct")) {
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
                    url: "php/mantenimientos/tipoRegistros/actualiza.php",
                    data: $("#formTipoRegistroAct").serialize(),
                    success: function (response) {
                        validaRespuestaActualizar(response, "php/mantenimientos/tipoRegistros/index.php", "modalTipoRegistro")
                        ocultarLoader();
                    }
                });
            }
        })
    }else{
        toastPersonalizada("Falta Datos","error")
    }
  }