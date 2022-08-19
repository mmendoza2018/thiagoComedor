<?php
session_start();
require_once("../conexion.php");
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
$conCedes = mysqli_query($conexion,"SELECT * FROM cedes WHERE CEDE_estado=1");
$conEmpresas = mysqli_query($conexion,"SELECT * FROM empresas WHERE EMPR_estado=1");
?>

<div class="container-fluid bg-white my-1 py-3">
  <div class="text-center mb-4">
    <h5 class="my-0">ATENCIONES PREVISTAS | <?php echo $hoy ?></h5>
  </div>
  <div class="row" id="llegaTablasEstadisticasEmpresas">
  </div>
</div>
<script>
  cargarContenido("php/estadisticas/tablasEmpresas.php","llegaTablasEstadisticasEmpresas");
</script>