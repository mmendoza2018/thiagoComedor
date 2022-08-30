<?php 
session_start();
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
$idCedeSesion = $_SESSION['datos_trabajador'][0]["idCede"];
if (isset($_POST["idCede"])) {
  $idCede = $_POST["idCede"];
}else{
  $idCede = $idCedeSesion;
}
require_once("../conexion.php");
$conCedes = mysqli_query($conexion,"SELECT * FROM cedes WHERE CEDE_estado=1");
?>

<div class="container-fluid bg-white my-1 py-3">
  <div class="text-center mb-4">
    <h5 class="my-0">ESTADISTICA ATENCIONES - <?php echo $hoy ?></h5>
  </div>
  <div class="col-3 ms-2 mb-4">
  <select class="form-select form-select-sm" onchange="obtenerTablasPorCede(this)">
    <?php foreach ($conCedes as $x) : 
      if ($x["CEDE_id"]==$idCede){ ?>
        <option value="<?php echo $x["CEDE_id"] ?>" selected><?php echo $x["CEDE_descripcion"] ?></option>
      <?php } else{ ?>
        <option value="<?php echo $x["CEDE_id"] ?>"><?php echo $x["CEDE_descripcion"] ?></option>
     <?php } ?>
    <?php endforeach; ?>
  </select>
  </div>
  <div class="row" id="llegaTablasEstadisticas">
    
  </div>
</div>
<script>
   data = new FormData();
  idCede = "<?php echo $idCede ?>";
  data.append("idCede",idCede)
  cargarContenidoMultiple(
    [fetch("php/estadisticas/tablas.php",{
      method:"POST",
      body:data
    })], 
    ["llegaTablasEstadisticas"]
  );
</script>
