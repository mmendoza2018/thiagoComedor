<?php
require_once("../conexion.php");
$cedes = mysqli_query($conexion, "SELECT * FROM cedes WHERE CEDE_estado=1");
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="container-fluid bg-white py-4" style="height: 95vh;">
  <div class="row gy-2">
    <?php foreach ($cedes as $x) : ?>

      <div class="col-sm-4 text-center ">
        <div class="card border-0 border-start shadow border-5 border-success p-3">
          <h5 class="text-uppercase"><?php echo $x["CEDE_descripcion"]  ?></h5>
          <div class="row">
            <?php
            $consulta = "SELECT TIAL_descripcion,(SELECT COUNT(TIAL_id01) FROM registros_alimentacion WHERE TIAL_id01=TIAL_id AND CEDE_id01='" . $x["CEDE_id"] . "' AND DATE(REAL_fecha)='$hoy') as conteo FROM tipos_alimentacion";

            foreach (mysqli_query($conexion, $consulta) as $y) : ?>
              <div class="col-4">
                <b><?php echo $y["TIAL_descripcion"]  ?></b>
                <h4 class="fw-bold"><?php echo $y["conteo"]  ?></h4>
              </div>
            <?php endforeach; ?>
            <a href="#" class="text-end" onclick="obtenerTablasPorCedeIndex('<?php echo $x['CEDE_id']  ?>')" style="text-decoration: none;"><b class="my-2 me-2">Mas detalles...</b></a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>