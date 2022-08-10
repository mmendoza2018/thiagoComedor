<?php require_once('modales.php') ?>

<div><h5>ALIMENTOS</h5></div>
<div class="container-fluid bg-white my-2 py-3">
    <div class="row g-5">
        <div class="col-sm-4">
            <form id="formAlimentos">
                <label class="mb-1">Descripción</label>
                <input type="text" class="form-control form-control-sm mb-2" data-validate name="descripcionAlimento">
                <label class="mb-1">Marca</label>
                <input type="text" class="form-control form-control-sm mb-2" data-validate name="marcaAlimento">
                <label class="mb-1">Unidad</label>
                <input type="text" class="form-control form-control-sm mb-2" data-validate name="unidadAlimento">
                <label class="mb-1">Precio</label>
                <input type="number" class="form-control form-control-sm mb-2" data-validate name="precioAlimento">
                <!-- <label class="mb-1">Tipo Alimento</label>
                <select class="form-select form-select-sm" data-validate name="tipoAlimento" required="">
                <option value="">-- SELECCIONE --</option>
                <option value="1">Normal</option>
                <option value="0">Otros</option>
                </select> -->
                <br>
                <button class="btn btn-blue-gyt btn-sm float-end" onclick="agregarAlimento()" type="button">AGREGAR</button>
            </form>
        </div>
        <div class="col-sm-8">
            <div id="contenedorTablaTipoAlimentos"></div>
        </div>
    </div>
</div>

<script>
  cargarContenido('php/mantenimientos/tipoAlimentos/tabla.php','contenedorTablaTipoAlimentos');
</script>