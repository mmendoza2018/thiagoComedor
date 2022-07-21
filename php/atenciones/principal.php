<div class="container-fluid bg-white my-1 py-3">
  <div class="text-center mb-4">
    <h5 class="my-0">REGISTRO ATENCIONES</h5>
  </div>
  <div class="row">
    <!-- formulario -->
    <div class="col-sm-3" id="formularioAtenciones"></div>
    <!-- fin formulario -->
    <!-- tabla Comensales -->
    <div class="col-sm-9" id="tablaAtenciones"></div>
    <!-- fin tabla Comensales -->
    <!-- modales -->
    <div id="modalesAtenciones"></div>
    <!-- fin modales -->
  </div>
</div>
<script>
  cargarContenidoMultiple(
    [fetch("php/atenciones/formAgrega.php"), fetch("php/atenciones/tabla.php"),fetch("php/atenciones/modales.php")], 
    ["formularioAtenciones", "tablaAtenciones","modalesAtenciones"]
  );
</script>