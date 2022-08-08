<?php
session_start();
$totalGeneral = 0;
$counTotal = 0;
?>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th colspan="8" class="text-center bg-opacity">Productos Agregados</th>
      </tr>
      <tr>
        <th>Descripción</th>
        <th>Marca</th>
        <th>Unidad</th>
        <th>cantidad</th>
        <th>Precio</th>
        <th>Total</th>
        <th>-</th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($_SESSION['sesionTipoAlimentos'])) { ?>
        <?php foreach ($_SESSION['sesionTipoAlimentos'] as $k => $value) :
          $totalAlimento = $value["cantidad"] * $value["precio"];
          $totalGeneral += $totalAlimento; ?>
          <tr>
            <td><?php echo $value["descripcion"]; ?></td>
            <td><?php echo $value["marca"]; ?></td>
            <td><?php echo $value["unidad"]; ?></td>
            <td><?php echo $value["cantidad"]; ?></td>
            <td><?php echo number_format($value["precio"], 2); ?></td>
            <td><?php echo number_format($totalAlimento,2); ?></td>
            <td>
              <a href="#" 
              onclick="EliminaTipoAlimentoSesion('<?php echo $k ?>')">
              <i class="fas fa-trash text-danger"></i>
              </a>
          </td>
          </tr>
          <?php $counTotal++; endforeach; } ?>
          <?php if ($counTotal <=0) { ?>
            <tr>
              <td colspan="8" class="text-center">No hay Productos agregados</td>
            </tr>
          <?php } ?>
    </tbody>
  </table>
</div>

<div class="d-flex w-100 justify-content-end">
  <div class="col-5" style="border-top: 2px solid black; border-bottom: 2px solid black;">
    <div class="row">
      <div class="col-6">
        <span class="fw-bold">Total Servicio</span>
      </div>
      <div class="col-6">
      <?php echo number_format($totalGeneral,2); ?>
      </div>
    </div>
  </div>
</div>