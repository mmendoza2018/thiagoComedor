<?php
session_start();
require_once("../conexion.php");
require_once("modales.php");
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
$fechaFinal = isset($_POST["fecha"]) ? $_POST["fecha"] : $hoy;
$idCedeSesion = $_SESSION['datos_trabajador'][0]["idCede"];
if (isset($_POST["idCede"])) {
  $CondicionCede = "AND CEDE_id01='" . $_POST['idCede'] . "'";
} else {
  $CondicionCede = "AND CEDE_id01='$idCedeSesion'";
}

$conEmpresas = mysqli_query($conexion, "SELECT * FROM empresas WHERE EMPR_estado=1");
$consultaTipoAlimentos = "SELECT TIAL_abreviacion,TIAL_id FROM tipo_alimentos WHERE TIAL_principal = 1 ORDER BY TIAL_id ASC";
$resTipoAlimentos = mysqli_query($conexion, $consultaTipoAlimentos);

?>
<?php foreach ($conEmpresas as $x) :

  $conAtencionesEsperadas = "SELECT * FROM atenciones_esperadas WHERE EMPR_id01 = " . $x["EMPR_id"] . " AND ATES_fecha = '$fechaFinal'";
  $resAtencionesEsperadas = mysqli_query($conexion, $conAtencionesEsperadas);
  $arrayAtencionesEsperadas = mysqli_fetch_assoc($resAtencionesEsperadas);
  $dataActualizar = @$arrayAtencionesEsperadas["ATES_cantidad_desayunos"] . "|" . @$arrayAtencionesEsperadas["ATES_cantidad_almuerzos"] . "|" . @$arrayAtencionesEsperadas["ATES_cantidad_cenas"] . "|" . $x["EMPR_id"] . "|" . $x["EMPR_razonSocial"] . "|" .@$arrayAtencionesEsperadas["ATES_id"];
?>
  <div class="col-sm-4 px-3 rounded-3">
    <div class="shadow p-2">
      <div class="d-flex justify-content-between align-items-center">
        <h6 class="text-center"><?php echo $x["EMPR_razonSocial"] ?></h6>
        <div class="dropdown">
          <a class="badge bg-primary dropdown-toggle text-decoration-none py-2" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            Atenciones del día
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <?php if (isset($arrayAtencionesEsperadas["ATES_id"])) { ?>
              <li data-bs-toggle="modal" data-bs-target="#modalActAtencionesDelDia" onclick="llenarDatosActAtencionesEsperadas('<?php echo $dataActualizar ?>')"><a class="dropdown-item" href="#">Actualizar</a></li>
            <?php } else { ?>
              <li data-bs-toggle="modal" data-bs-target="#modalAddAtencionesDelDia" onclick="llenarDatosAddAtencionesEsperadas('<?php echo $dataActualizar ?>')"><a class="dropdown-item" href="#">Agregar</a></li>
            <?php }  ?>
          </ul>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-6">
          <p class="text-center fw-bold">Atendidos</p>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                <tr>
                  <?php foreach ($resTipoAlimentos as $y) : ?>
                    <th class="text-center"><?php echo $y["TIAL_abreviacion"] ?></th>
                  <?php endforeach; ?>
                </tr>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php foreach ($resTipoAlimentos as $y) :
                    $consultaTotalAlimento = "SELECT  count(*) AS numRegistros FROM registros_alimentacion ra
                                                LEFT JOIN comensales co ON ra.COME_id01 = co.COME_id
                                                INNER JOIN empresas em ON co.EMPR_id01 = em.EMPR_id
                                                WHERE TIAL_id01 = " . $y["TIAL_id"] . " AND DATE(REAL_fecha) ='$fechaFinal' AND EMPR_id01 = " . $x["EMPR_id"] . "";
                    $arrayConteoAlimentos = mysqli_fetch_assoc(mysqli_query($conexion, $consultaTotalAlimento));
                  ?>
                    <th class="text-center"><?php echo $arrayConteoAlimentos["numRegistros"] ?></th>
                  <?php endforeach; ?>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-6">
          <p class="text-center fw-bold">Por atender</p>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th class="text-center">D</th>
                  <th class="text-center">A</th>
                  <th class="text-center">C</th>
                </tr>
              </thead>
              <tbody>
                <?php

                if (mysqli_num_rows($resAtencionesEsperadas) > 0) {
                  foreach ($resAtencionesEsperadas as $t) : ?>
                    <tr>
                      <td class="text-center"><?php echo $t["ATES_cantidad_desayunos"] ?></td>
                      <td class="text-center"><?php echo $t["ATES_cantidad_almuerzos"] ?></td>
                      <td class="text-center"><?php echo $t["ATES_cantidad_cenas"] ?></td>
                    </tr>
                  <?php endforeach;
                } else { ?>
                  <tr>
                    <td colspan="3" class="text-center">Sin registros</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>

      </div>
    </div>
  </div>
<?php endforeach ?>