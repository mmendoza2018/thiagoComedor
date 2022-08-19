<?php require_once('modales.php') ?>

<div><h5>TIPO ATENCIONES</h5></div>
<div class="container-fluid bg-white my-2 py-3">
    <div class="row g-5">
        <div class="col-sm-4">
            <form id="formTipoAtencion">
                <label class="mb-1">Descripción</label>
                <input type="text" class="form-control form-control-sm mb-2" data-validate name="descripcionTipoAtencion">
                <button class="btn btn-primary btn-sm float-end" onclick="agregarTipoAtencion()" type="button">AGREGAR</button>
            </form>
        </div>
        <div class="col-sm-8">
            <div id="contenedorTablaTipoAtenciones"></div>
        </div>
    </div>
</div>

<script>
  cargarContenido('php/mantenimientos/tipoAtenciones/tabla.php','contenedorTablaTipoAtenciones');
</script>