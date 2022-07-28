<?php require_once('modales.php') ?>

<div><h5>TIPO REGISTROS</h5></div>
<div class="container-fluid bg-white my-2 py-3">
    <div class="row g-5">
        <div class="col-sm-4">
            <form id="formTipoRegistro">
                <label class="mb-1">Descripción</label>
                <input type="text" class="form-control form-control-sm mb-2" data-validate name="descripcionTipoRegistro">
                <button class="btn btn-blue-gyt btn-sm float-end" onclick="agregarTipoRegistro()" type="button">Agregar</button>
            </form>
        </div>
        <div class="col-sm-8">
            <div id="contenedorTablaTipoRegistros"></div>
        </div>
    </div>
</div>

<script>
  cargarContenido('php/mantenimientos/tipoRegistros/tabla.php','contenedorTablaTipoRegistros');
</script>