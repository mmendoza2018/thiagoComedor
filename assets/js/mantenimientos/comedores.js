function agregarComedor() {
    event.preventDefault();
    console.log(event);
    if (validar_campos("formComedores")) {
        verLoader()
        $.ajax({
            type: "POST",
            url: "php/mantenimientos/comedores/agrega.php",
            data: $("#formComedores").serialize(),
            success: function (response) {
                validaRespuestasAgregar(response, "php/mantenimientos/comedores/index.php")
                ocultarLoader();
            }
        });
    } else {
        toastPersonalizada("Datos Incompletos","error")
    }
}

const llenarDatosComedores = (dato) => {
    let x = dato.split("|");
    document.getElementById("CEDE_id").value = x[0];
    document.getElementById("CEDE_descripcion").value = x[1];
    document.getElementById("CEDE_estado").value = x[2];

}

const actualizaComedor = () => {
    if (validar_campos("formComedorAct")) {
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
                    url: "php/mantenimientos/comedores/actualiza.php",
                    data: $("#formComedorAct").serialize(),
                    success: function (response) {
                        validaRespuestaActualizar(response, "php/mantenimientos/comedores/index.php", "modalComedoresAct")
                        ocultarLoader();
                    }
                });
            }
        })
    }else{
        toastPersonalizada("Falta Datos","error")
    }
  }