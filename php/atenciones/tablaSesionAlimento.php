<?php
session_start();
$sumaTotal = 0;
$sumaTotalMovilizacion=0;
$counTotal = 0;
$countTotalMovilizacion = 0;
?>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th colspan="8" class="text-center bg-opacity">Información Alquiler</th>
      </tr>
      <tr>
        <th>Descripción</th>
        <th>Marca</th>
        <th>Unidad</th>
        <th>Precio</th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($_SESSION['sesionTipoAlimentos'])) { ?>
        <?php foreach ($_SESSION['sesionTipoAlimentos'] as $k => $value) :
          ?>
          <tr>
            <td><?php echo $value["descripcion"]; ?></td>
            <td><?php echo $value["marca"]; ?></td>
            <td><?php echo $value["unidad"]; ?></td>
            <td><?php echo number_format($value["precio"], 2); ?></td>
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
              <td colspan="8" class="text-center">No hay equipos agregados</td>
            </tr>
          <?php } ?>
    </tbody>
  </table>
</div>

<div class="d-flex w-100 justify-content-end">
  <div class="col-4" style="border-top: 2px solid black; border-bottom: 2px solid black;">
    <div class="row">
      <div class="col-6">
        <span class="fw-bold">Total Servicio</span>
      </div>
      <div class="col-6">
      <?php echo number_format($sumaTotalMovilizacion + $sumaTotal,2); ?>
      </div>
    </div>
  </div>
</div>