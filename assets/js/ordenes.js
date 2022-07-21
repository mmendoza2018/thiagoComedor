const agregaTipoOrden = () => {
    if (validar_campos("formAgregaTipoOrden")) {
        verLoader();
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "php/ordenes/detalle_orden/agrega.php",
            data: $("#formAgregaTipoOrden").serialize(),
            success: function (response) {
                if (response === "true") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Agregado con exito!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    let formulario = document.getElementById("formAgregaTipoOrden");
                    formulario.monto.value = "";
                    formulario.concepto.value = "";
                    formulario.observacion.value = "";
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Fallo al agregar!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                ocultarLoader();
            }
        });
    } else {
        alertaWarnings()
    }
}
const obteneridElSeleccionado = (idFormulario, classInput) => {
    //la clase del input formulario debe ser igual al value del list
   let valueSelect = document.getElementById(idFormulario).querySelector(`.${classInput}`).value;
   let options = document.querySelectorAll(`#${classInput} option`);
   let idFinal="";
   options.forEach(e => {
      // console.log(e.textContent+"--"+valueSelect);
       if ((e.textContent.replace(/\s+/g, ''))===(valueSelect.replace(/\s+/g, ''))) idFinal= e.dataset.value;
   });
   return idFinal;
}

const agregaOrden = async () => {
    if (validar_campos("formAgregaOrden")) {
        let centroCosto = await obteneridElSeleccionado("formAgregaOrden","centroCostoAddOp")
        if (centroCosto==="") return alert("Centro de costo No valido");
        verLoader();
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "php/ordenes/agrega.php",
            data: $("#formAgregaOrden").serialize()+ '&centroCosto=' + centroCosto,
            success: function (response) {
                if (response === "true") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Agregado con exito!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    document.getElementById("formAgregaOrden").reset();
                    $("#modalAddOrden").modal("hide");
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Fallo al agregar!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                ocultarLoader();
            }
        });
    } else {
        alertaWarnings()
    }
}

const llenarDatoInput = (datos, idInputId, idInputDescripcion) => {
    let [id, campo1, campo2] = datos.split("|");
    let inputId = document.getElementById(idInputId).value = id;
    let inputdescripcion = document.getElementById(idInputDescripcion).value = campo1;
}

const verListaOrden = (idPersona) => {
    verLoader()
    $.ajax({
        type: "POST",
        url: "php/ordenes/lista_ordenes.php",
        data: "idPersona=" + idPersona,
        success: function (response) {
            $("#llegaListadoOrdenes").html(response)
            ocultarLoader();
        }
    });
}

const selectTipoMoneda = (elemento) => {
    verLoader()
    $.ajax({
        type: "POST",
        url: "php/ordenes/historial.php",
        data: "moneda=" + document.getElementById("tipoMoneda").value,
        success: function (response) {
            $("#contenido").html(response)
            ocultarLoader();
            document.getElementById("tipoMoneda").value=elemento.value;
        }
    });
}
const verListaDetalleOrden = (idOrden) => {
    verLoader()
    $.ajax({
        type: "POST",
        url: "php/ordenes/lista_detalle_orden.php",
        data: "idOrden=" + idOrden,
        success: function (response) {
            $("#llegaListadoDetOrdenes").html(response)
            let toasts = document.querySelectorAll('.popover-dismiss')
            toasts.forEach(e => {
                var popover = new bootstrap.Popover(e, {
                    container: 'body',
                    trigger: 'focus'
                })
            });
            ocultarLoader();
        }
    });
}

const verListaDetalleOrdenActualiza = (idOrden) => {
    verLoader()
    $.ajax({
        type: "POST",
        url: "php/ordenes/lista_detalle_actualiza.php",
        data: "idOrden=" + idOrden,
        success: function (response) {
            $("#llegaListadoDetOrdenesAct").html(response)
            ocultarLoader();
        }
    });
}

const verPdfOrden = (idOrden) => {
    window.open(`php/generaPDF/orden/index.php?idOrden=${idOrden}`, "facturacion", "width=650,height=600,margin=0,padding=5,scrollbars=SI,top=80,left=370");
}

const generarReporte = (reporte) => {
    event.preventDefault()
    let formulario = document.getElementById("formReporte")
    if (reporte==="excel") {
        window.location.href=`php/generaEXCEL/reporte_orden.php?trabajador=${formulario.trabajador.value}&fInicio=${formulario.fInicio.value}&fFinal=${formulario.fFinal.value}&estado=${formulario.estado.value}`;
    }else{
        window.open(`php/generaPDF/reporte/index.php?trabajador=${formulario.trabajador.value}&fInicio=${formulario.fInicio.value}&fFinal=${formulario.fFinal.value}&estado=${formulario.estado.value}`, "facturacion", "width=650,height=600,margin=0,padding=5,scrollbars=SI,top=80,left=370");
    }
    
}

function cargarControlesReporte() {
    verLoader()
    $.ajax({
        url: "php/ordenes/reporte/controles_reporte.php",
        success: function (response) {
            $(`#contenido`).html(response)
            let fechaActual = new Date(),
                anio = fechaActual.getFullYear(),
                mes = fechaActual.getMonth() + 1;
            mes
            mes = (mes < 10) ? `0${mes}` : `${mes}`;
            let primerDiaMes = `${anio}-${mes}-01`;
            let ultimoDiaMes = `${anio}-${mes}-${new Date(anio, mes, 0).getDate()}`;
            document.getElementById("PrimerDiaReporte").value = primerDiaMes;
            document.getElementById("ultimoDiaReporte").value = ultimoDiaMes;
            ocultarLoader();
        }
    });
}

const aprobarOrden = (idOrden) => {
    Swal.fire({
            title: '¿Estas seguro de aprobar esta OP?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                verLoader();
                fetch("php/ordenes/aprueba_envia_orden.php", {
                        method: "POST",
                        body: JSON.stringify(idOrden),
                    })
                    .then(res => res.text())
                    .then(text => {
                        console.log(text);
                        if (text === "1") {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Aprobado con exito!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            verListaDetalleOrden(idOrden)
                            $("#contenido").load("php/ordenes/historial.php")
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Fallo al Aprobar!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                        ocultarLoader();
                    })
            }
        })
        .catch(error => console.log(error))
}

const actualizarDetalleOrden = (contador) => {
        let datos = $("#formDetalleOrdenAct").serialize();
            datos += '&contador='+contador;
    Swal.fire({
            title: '¿Estas seguro de actualizar?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                verLoader();
                $.ajax({
                    type: "POST",
                    url: "php/ordenes/detalle_orden/actualiza.php",
                    data: datos,
                    success: function (response) {
                        if (response === "true") {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Actualizado con exito!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Fallo al Actualizar!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                        ocultarLoader();
                    }
                });
            }
        })
}


/* const ModalFinalizacionOrden =  (idOrden,idPersona) => {
 $("#modalAlertaFinOP").modal("show")
 document.getElementById("idOrdenFinalizacion").value=idOrden;
 document.getElementById("idPersonaFinalizacion").value=idPersona;
}
 */
const AprobarEnviarOrdenModals = (idOrden, idPersona,textoDescriptivo,envioDocPredictivo=false) => { // archivo de donde se da click, para actualizar o no una vista en especifica
    event.preventDefault();
    Swal.fire({
        title: `¿Estas seguro de ${textoDescriptivo} esta OP?`,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'si',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            verLoader();
            $.ajax({
                type: "POST",
                url: "php/ordenes/aprueba_envia_orden.php",
                data: "idOrden=" + idOrden,
                success: function (response) {
                    if (response === "1") {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: `${textoDescriptivo} con exito!`,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        if (document.getElementById("modalListadoOrden").classList.contains("show")) {
                            verListaOrden(idPersona)
                        }
                        verListaDetalleOrden(idOrden)
                        $("#contenido").load("php/ordenes/historial.php")
                        $("#modalAlertaFinOP").modal("hide")
                        
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Fallo al Aprobar!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    ocultarLoader();
                }
            });
        }
    })

}

const AnularOrden = (idOrden) => { // archivo de donde se da click, para actualizar o no una vista en especifica

    event.preventDefault();
    Swal.fire({
        title: '¿Estas seguro de Anular esta OP?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'si',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            verLoader();
            $.ajax({
                type: "POST",
                url: "php/ordenes/anula_orden.php",
                data: "idOrden=" + idOrden,
                success: function (response) {
                    if (response === "1") {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'La OP fue anulada!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        verListaDetalleOrden(idOrden)
                        $("#contenido").load("php/ordenes/historial.php")
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Fallo al Anular!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    ocultarLoader();
                }
            });
        }
    })

}

const ModalInicioTransaccion = (idOrden, idPersona) => {
    $("#modalInicioTransaccion").modal("show")
    document.getElementById("idOrdenTransaccion").value = idOrden;
    document.getElementById("idPersonaTransaccion").value = idPersona;
}

const envioInicioTransaccion = () => {
    if (validar_campos("formInicioTransaccion")) {
        verLoader();
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "php/ordenes/inicio_transaccion.php",
            data: $("#formInicioTransaccion").serialize(),
            success: function (response) {
                console.log(response);
                if (response === "1") {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Actualizo con exito!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    let formulario = document.getElementById("formInicioTransaccion");
                    formulario.reset();
                    $("#modalInicioTransaccion").modal("hide")
                    $("#contenido").load("php/ordenes/historial.php")
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Fallo al iniciar transacción!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                ocultarLoader();
            }
        });
    } else {
        alertaWarnings()
    }
}