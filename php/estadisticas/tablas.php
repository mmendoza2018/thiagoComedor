<?php
session_start();
require_once("../conexion.php");
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
$totalDesayunos=0;
$totalAlmuerzos=0;
$totalCenas=0;
$idCedeSesion = $_SESSION['datos_trabajador'][0]["idCede"];
if (isset($_POST["idCede"])) {
  $CondicionCede = "AND CEDE_id01='".$_POST['idCede']."'";
}else{
  $CondicionCede="AND CEDE_id01='$idCedeSesion'";;
}
$consultaDesayuno = "SELECT EMPR_razonSocial, 
 (SELECT COUNT(EMPR_id01) FROM comensales c 
 INNER JOIN registros_alimentacion ra ON c.COME_id=ra.COME_id01
 WHERE EMPR_id01=EMPR_id AND DATE(REAL_fecha)='$hoy' AND TIAL_id01=1 $CondicionCede ) as conteo 
 FROM empresas";

$consultaAlmuerzo = "SELECT EMPR_razonSocial, 
  (SELECT COUNT(EMPR_id01) FROM comensales c 
  INNER JOIN registros_alimentacion ra ON c.COME_id=ra.COME_id01
  WHERE EMPR_id01=EMPR_id AND DATE(REAL_fecha)='$hoy' AND TIAL_id01=2 $CondicionCede ) as conteo 
  FROM empresas";

$consultaCena = "SELECT EMPR_razonSocial, 
  (SELECT COUNT(EMPR_id01) FROM comensales c 
  INNER JOIN registros_alimentacion ra ON c.COME_id=ra.COME_id01
  WHERE EMPR_id01=EMPR_id AND DATE(REAL_fecha)='$hoy' AND TIAL_id01=3 $CondicionCede ) as conteo 
  FROM empresas";
?>
<div class="col-sm-4 px-3 rounded-3">
  <div class="shadow p-2">
    <h6 class="text-center">DESAYUNO</h6>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Empresa</th>
            <th>Conteo</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (mysqli_query($conexion, $consultaDesayuno) as $x) : 
            $totalDesayunos += $x["conteo"]; ?>
            <tr>
              <td><?php echo $x["EMPR_razonSocial"] ?></td>
              <td><?php echo $x["conteo"] ?></td>
              <td><?php echo $x["conteo"] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="card border-0 border-start border-5 border-success p-3" style="background-color: #F9F9F9;">
        <b class="text-center">Total</b>
        <h3 class="text-center"><?php echo $totalDesayunos ?></h3>
      </div>
    </div>
  </div>
</div>
<div class="col-sm-4 px-3 rounded-3">
  <div class="shadow p-2">
    <h6 class="text-center">ALMUERZO</h6>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Empresa</th>
            <th>Conteo</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (mysqli_query($conexion, $consultaAlmuerzo) as $y) : 
            $totalAlmuerzos += $y["conteo"]; ?>
            <tr>
              <td><?php echo $y["EMPR_razonSocial"] ?></td>
              <td><?php echo $y["conteo"] ?></td>
              <td><?php echo $y["conteo"] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="card border-0 border-start border-5 border-success p-3" style="background-color: #F9F9F9;">
        <b class="text-center">Total</b>
        <h3 class="text-center"><?php echo $totalAlmuerzos ?></h3>
      </div>
    </div>
  </div>
</div>
<div class="col-sm-4 px-3 rounded-3">
  <div class="shadow p-2">
    <h6 class="text-center">CENA</h6>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Empresa</th>
            <th>Conteo</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (mysqli_query($conexion, $consultaCena) as $x) :
            $totalCenas += $x["conteo"]; ?>
            <tr>
              <td><?php echo $x["EMPR_razonSocial"] ?></td>
              <td><?php echo $x["conteo"] ?></td>
              <td><?php echo $x["conteo"] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="card border-0 border-start border-5 border-success p-3" style="background-color: #F9F9F9;">
        <b class="text-center">Total</b>
        <h3 class="text-center"><?php echo $totalCenas ?></h3>
      </div>
    </div>
  </div>
</div>