function agregarCargo() {
    event.preventDefault();
    if (validar_campos("formCargo")) {
        verLoader()
        $.ajax({
            type: "POST",
            url: "php/mantenimientos/cargos/agrega.php",
            data: $("#formCargo").serialize(),
            success: function (response) {
                validaRespuestasAgregar(response, "php/mantenimientos/cargos/index.php")
                ocultarLoader();
            }
        });
    } else {
        toastPersonalizada("Datos Incompletos","error")
    }
}

const llenarDatosCargo = (dato) => {
    let x = dato.split("|");
    document.getElementById("AREA_id").value = x[0];
    document.getElementById("AREA_descripcion").value = x[1];
    document.getElementById("AREA_estado").value = 1;

}

const actualizaCargos = () => {
    if (validar_campos("formCargosAct")) {
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
                    url: "php/mantenimientos/cargos/actualiza.php",
                    data: $("#formCargosAct").serialize(),
                    success: function (response) {
                        validaRespuestaActualizar(response, "php/mantenimientos/cargos/index.php", "modalCargosAct")
                        ocultarLoader();
                    }
                });
            }
        })
    }else{
        toastPersonalizada("Falta Datos","error")
    }
  }