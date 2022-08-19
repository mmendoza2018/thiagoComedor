<?php require_once('modales.php') ?>

<div><h5>EMPRESAS</h5></div>
<div class="container-fluid bg-white my-2 py-3">
    <div class="row g-5">
        <div class="col-sm-4">
            <form id="formEmpresa">
                <label class="mb-1">RUC</label>
                <input type="number" class="form-control form-control-sm mb-2" data-validate name="numeroRuc">
                <label class="mb-1">Razon Social</label>
                <input type="text" class="form-control form-control-sm mb-2" data-validate name="descripcionRazonSocial">
                <button class="btn btn-primary btn-sm float-end" onclick="agregarEmpresa()" type="button">AGREGAR</button>
            </form>
        </div>
        <div class="col-sm-8">
            <div id="contenedorTablaEmpresas"></div>
        </div>
    </div>
</div>

<script>
  cargarContenido('php/mantenimientos/empresas/tabla.php','contenedorTablaEmpresas');
</script>