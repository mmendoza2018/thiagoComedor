<?php require_once('modales.php') ?>

<div>
    <h5>UNIDADES MINERAS</h5>
</div>
<div class="container-fluid bg-white my-2 py-3">
    <div class="row g-5">
        <div class="col-sm-4">
            <form id="formUnidadMinera">
                <label class="mb-1">Descripción</label>
                <input type="text" class="form-control form-control-sm mb-2" data-validate name="descripcion">
                <button class="btn btn-primary btn-sm float-end" onclick="agregarUnidadMinera()" type="button">AGREGAR</button>
            </form>
        </div>
        <div class="col-sm-8">
            <div id="contenedorTablaUnidadMinera"></div>
        </div>
    </div>
</div>

<script>
    cargarContenido('php/mantenimientos/unidadMinera/tabla.php', 'contenedorTablaUnidadMinera');
</script>