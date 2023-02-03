function agregarTipoDocumento() {
    event.preventDefault();
    console.log(event);
    if (validar_campos("formTipoDocumentos")) {
        verLoader()
        $.ajax({
            type: "POST",
            url: "php/mantenimientos/tipoDocumento/agrega.php",
            data: $("#formTipoDocumentos").serialize(),
            success: function (response) {
                console.log('response', response)
                validaRespuestasAgregar(response, "php/mantenimientos/tipoDocumento/index.php")
                ocultarLoader();
            }
        });
    } else {
        toastPersonalizada("Datos Incompletos","error")
    }
}

const llenarTipoDocumento = (dato) => {
    let x = dato.split("|");
    document.getElementById("idTidoAct").value = x[0];
    document.getElementById("descripcionTidoAct").value = x[1];

}

const actualizaTipoDocumento = () => {
    if (validar_campos("formTipoDocEquipoAct")) {
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
                    url: "php/mantenimientos/tipoDocumento/actualiza.php",
                    data: $("#formTipoDocEquipoAct").serialize(),
                    success: function (response) {
                        console.log('response', response)
                        validaRespuestaActualizar(response, "php/mantenimientos/tipoDocumento/index.php", "modalTipoDocEquipoAct")
                        ocultarLoader();
                    }
                });
            }
        })
    }else{
        toastPersonalizada("Falta Datos","error")
    }
  }