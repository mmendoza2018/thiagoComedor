function agregarEmpresa() {
    event.preventDefault();
    console.log(event);
    if (validar_campos("formEmpresa")) {
        verLoader()
        $.ajax({
            type: "POST",
            url: "php/mantenimientos/empresas/agrega.php",
            data: $("#formEmpresa").serialize(),
            success: function (response) {
                validaRespuestasAgregar(response, "php/mantenimientos/empresas/index.php")
                ocultarLoader();
            }
        });
    } else {
        toastPersonalizada("Datos Incompletos","error")
    }
}

const llenarDatosEmpresas = (dato) => {
    let x = dato.split("|");
    document.getElementById("EMPR_id").value = x[0];
    document.getElementById("EMPR_razonSocial").value = x[1];
    document.getElementById("EMPR_ruc").value = x[2];
    document.getElementById("EMPR_estado").value = x[3];

}

const actualizaEmpresa = () => {
    if (validar_campos("formEmpresaAct")) {
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
                    url: "php/mantenimientos/empresas/actualiza.php",
                    data: $("#formEmpresaAct").serialize(),
                    success: function (response) {
                        validaRespuestaActualizar(response, "php/mantenimientos/empresas/index.php", "modalEmpresasAct")
                        ocultarLoader();
                    }
                });
            }
        })
    }else{
        toastPersonalizada("Falta Datos","error")
    }
  }