<div class="container-fluid bg-white my-1 py-3" style="height: 90vh;">
<div class="d-flex justify-content-center align-items-center h-100">
  <div class="w-50">
    <form id="formLectorQr" onsubmit="lecturaRegistroComensales(this)">
    <label for="inputLector" class="position-relative">
      <img src="https://static.vecteezy.com/system/resources/previews/001/199/361/non_2x/barcode-png.png" class="img-fluid" alt="">
      <!-- linea lector -->
      <div class="container_lector hide_lector" id="lineaLectora"></div>
    </label>
    <input type="hidden" name="lecturaRapida" value="true">
      <input type="text" id="inputLector" name="dniComensal" style="width: 1px;" autocomplete="off" class="hide_lector" onfocusout="ocultarLecturaCodigo()" onfocus="mostrarLecturaCodigo()">
       <button type="submit" class="hide_lector" style="width: 1px; height: 1px;">Enviar</button>
    </form>
  </div>
  </div>
</div>