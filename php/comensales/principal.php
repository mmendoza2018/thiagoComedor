<div class="container-fluid bg-white my-1 py-3">
  <div class="text-center mb-4">
    <h5 class="my-0">REGISTRO COMENSALES  </h5>
  </div>
  <div class="row">
    <!-- formulario -->
    <div class="col-sm-4" id="formularioComensales"></div>
    <!-- fin formulario -->
    <!-- tabla Comensales -->
    <div class="col-sm-8" id="tablaComensales"></div>
    <!-- fin tabla Comensales -->
    <!-- modales -->
    <div id="modalesComensales"></div>
    <!-- fin modales -->
  </div>
</div>
<script>
  cargarContenidoMultiple(
    [fetch("php/comensales/formAgrega.php"), fetch("php/comensales/tabla.php"),fetch("php/comensales/modales.php")], 
    ["formularioComensales", "tablaComensales","modalesComensales"]
  );
</script>