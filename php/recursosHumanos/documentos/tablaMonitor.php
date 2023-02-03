<?php
require_once "../../conexion.php";
require_once "modales.php";

$fechaActual = date("Y-m-d");
$contador = 1;
//sumo 1 día
$fechaEnTreintaDias =  date("Y-m-d", strtotime($fechaActual . "+ 29 days"));
$consulta = "SELECT *
FROM ( 
  SELECT MAX(DOCU_id) as max_id, do.TIDO_id01, DOCU_fecha_vencimiento,DOCU_fecha_ingreso,PER_nombres,PER_apellidos,TIDO_descripcion, PER_usuario
  FROM documentos do 
INNER JOIN tipo_documentos td ON do.TIDO_id01 = td.TIDO_id 
INNER JOIN personas pe ON do.PER_id01 = pe.PER_id 
WHERE DOCU_fecha_vencimiento < '$fechaEnTreintaDias' GROUP BY do.TIDO_id01 ) as t1 
INNER JOIN documentos t2 ON t1.max_id = t2.DOCU_id";

$resDocumentos = mysqli_query($conexion, $consulta);
?>
<div>
  <h5>MONITOR DE ALERTAS</h5>
</div>
<div class="container-fluid bg-white my-2 py-3">
  <div class="table-responsive">
    <table id="tablaMonitorAlertas" class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>DNI</th>
          <th>Nombres y Apellidos</th>
          <th>Documento</th>
          <th>Descripción</th>
          <th>Fecha Vencimiento</th>
          <th>Alerta del Sistema</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($resDocumentos as $x) {
          $idDocumento = $x["DOCU_id"];
          $classClircle = ($fechaActual >= $x["DOCU_fecha_vencimiento"]) ? "text-danger" : "text-warning";
          $data = $x["DOCU_id"] . "|" . $x["PER_id01"] . "|" . $x["TIDO_id01"] . "|" . $x["DOCU_fecha_ingreso"] . "|" . $x["DOCU_fecha_vencimiento"] . "|" . $x["DOCU_numero"] . "|" . $x["DOCU_descripcion"] . "|" . $x["DOCU_empresa"] . "|" . $x["DOCU_observacion"] . "|" . $x["PER_id01"];
          $descripcionRecortado = null;
          if(strlen($x["TIDO_descripcion"]) > 50)  {
            $descripcionRecortado = substr($x["TIDO_descripcion"], 0, 50);
            $descripcionRecortado.="...";
            $descripcionDoc = $descripcionRecortado;
          }else {
            $descripcionDoc = $x["TIDO_descripcion"];
          }
        ?>
          <tr>
            <td><?php echo $contador; ?></td>
            <td><?php echo $x["PER_usuario"]; ?></td>
            <td><?php echo $x["PER_nombres"] . ' ' . $x["PER_apellidos"]; ?></td>
            <td><?php echo $descripcionDoc ?></td>
            <td><?php echo $x["DOCU_descripcion"] ?></td>
            
            <td>
              <i class="fas fa-circle <?php echo $classClircle ?>"></i>
              <?php echo $x["DOCU_fecha_vencimiento"]; ?>
            </td>
            <td class="text-center">
              <a class="link_edit text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalActDocPersonal" onclick="llenarDocumentosAct('<?php echo $data ?>',true)" href="#">
                <i class="fa fa-edit"></i>
              </a>
              |
              <a class="link_edit text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalVerDocPersonal" onclick="verDocumentoPersonal('<?php echo $idDocumento ?>')" href="#">
                <i class="fa fa-print"></i>
              </a>
            </td>
          </tr>
        <?php $contador++; } ?>
      </tbody>
    </table>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#tablaMonitorAlertas').DataTable({
      "info": false,
      "ordering": false,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
      }
    });
  });
</script>