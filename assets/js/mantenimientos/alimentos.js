function agregarAlimento() {
    event.preventDefault();
    console.log(event);
    if (validar_campos("formAlimentos")) {
        verLoader()
        $.ajax({
            type: "POST",
            url: "php/mantenimientos/tipoAlimentos/agrega.php",
            data: $("#formAlimentos").serialize(),
            success: function (response) {
                validaRespuestasAgregar(response, "php/mantenimientos/tipoAlimentos/index.php")
                ocultarLoader();
            }
        });
    } else {
        toastPersonalizada("Datos Incompletos","error")
    }
}

const llenarDatosAlimentos = (dato) => {
    let x = dato.split("|");
    document.getElementById("TIAL_id").value = x[0];
    document.getElementById("TIAL_descripcion").value = x[1];
    document.getElementById("TIAL_marca").value = x[2];
    document.getElementById("TIAL_unidad").value = x[3];
    document.getElementById("TIAL_precio").value = x[4];
    //document.getElementById("TIAL_principal").value = x[5];
    document.getElementById("TIAL_estado").value = x[7];

}

const actualizaTipoAlimento = () => {
    if (validar_campos("formTipoAlimentoAct")) {
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
                    url: "php/mantenimientos/tipoAlimentos/actualiza.php",
                    data: $("#formTipoAlimentoAct").serialize(),
                    success: function (response) {
                        validaRespuestaActualizar(response, "php/mantenimientos/tipoAlimentos/index.php", "modalAlimentoAct")
                        ocultarLoader();
                    }
                });
            }
        })
    }else{
        toastPersonalizada("Falta Datos","error")
    }
  }