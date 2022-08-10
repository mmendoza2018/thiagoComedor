<?php require_once('modales.php') ?>

<div><h5>COMEDORES</h5></div>
<div class="container-fluid bg-white my-2 py-3">
    <div class="row g-5">
        <div class="col-sm-4">
            <form id="formComedores">
                <label class="mb-1">Descripción</label>
                <input type="text" class="form-control form-control-sm mb-2" data-validate name="descripcionComedor">
                <button class="btn btn-blue-gyt btn-sm float-end" onclick="agregarComedor()" type="button">REGISTRAR</button>
            </form>
        </div>
        <div class="col-sm-8">
            <div id="contenedorTablaComedores"></div>
        </div>
    </div>
</div>

<script>
  cargarContenido('php/mantenimientos/comedores/tabla.php','contenedorTablaComedores');
</script>