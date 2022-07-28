<?php
include_once("../../conexion.php");
$conTipoEquipo = mysqli_query($conexion, "SELECT * FROM horarios WHERE HORA_estado=1");
?>
<div class="table-responsive">
    <table id="tablaHorarios" class="table table-striped">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($conTipoEquipo as $x) : 
            $datos = $x["HORA_id"]."|".$x["HORA_inicio"]."|".$x["HORA_final"]."|".$x["TIAL_id01"]."|".$x["HORA_estado"];?>
                <tr>
                    <td><?php echo $x["HORA_id"] ?></td>
                    <td><?php echo $x["HORA_inicio"] ?></td>
                    <td><?php echo $x["HORA_final"] ?></td>
                    <td><center><a href="#"  data-bs-toggle="modal" data-bs-target="#modalHorarioAct" onclick="llenarDatosHorario('<?php echo $datos ?>')"><i class="fas fa-edit text-dark"></i></a></center></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tablaHorarios').DataTable({
            "info":false,
            "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
        });
    });
</script>
