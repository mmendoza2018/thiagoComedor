<div class="container-fluid bg-white my-1 py-3" style="height: 90vh;">
<div class="d-flex justify-content-center align-items-center h-100">
  <div class="col-12 col-md-5 border border-1 border-secondary shadow p-3">
    <form id="formLectorQr" onsubmit="lecturaRegistroComensales(this)">
    <label for="inputLectorTeclado" class="fw-bold mb-2">Digite el DNI</label>
    <input type="hidden" name="lecturaRapida" value="true">
      <input type="number" id="inputLectorTeclado" name="dniComensal" oninput="validaLongitudDni(this)" autocomplete="off" class="form-control fw-bold">
      <button type="submit" class="btn btn-primary d-block mx-auto mt-3">REGISTRAR COMENSAL</button>
    </form>
  </div>
  </div>
</div>