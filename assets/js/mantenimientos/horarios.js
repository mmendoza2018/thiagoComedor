function agregarHorario() {
    event.preventDefault();
    console.log(event);
    if (validar_campos("formHorarios")) {
        verLoader()
        $.ajax({
            type: "POST",
            url: "php/mantenimientos/horarios/agrega.php",
            data: $("#formHorarios").serialize(),
            success: function (response) {
                validaRespuestasAgregar(response, "php/mantenimientos/horarios/index.php")
                ocultarLoader();
            }
        });
    } else {
        toastPersonalizada("Datos Incompletos","error")
    }
}

const llenarDatosHorario = (dato) => {
    let x = dato.split("|");
    document.getElementById("HORA_id").value = x[0];
    document.getElementById("HORA_inicio").value = x[1];
    document.getElementById("HORA_final").value = x[2];
    document.getElementById("TIAL_id01").value = x[3];
    document.getElementById("HORA_estado").value = x[4];

}

const actualizaHorario = () => {
    if (validar_campos("formHorariosAct")) {
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
                    data: $("#formHorariosAct").serialize(),
                    success: function (response) {
                        validaRespuestaActualizar(response, "php/mantenimientos/comedores/index.php", "modalHorarioAct")
                        ocultarLoader();
                    }
                });
            }
        })
    }else{
        toastPersonalizada("Falta Datos","error")
    }
  }