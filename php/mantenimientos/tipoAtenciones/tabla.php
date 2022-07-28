<?php
include_once("../../conexion.php");
$conTipoEquipo = mysqli_query($conexion, "SELECT * FROM tipos_atencion WHERE TIAT_estado=1");
?>
<div class="table-responsive">
    <table id="tablaTipoAtencion" class="table table-striped">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Descripción</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($conTipoEquipo as $x) : 
            $datos = $x["TIAT_id"]."|".$x["TIAT_descripcion"]."|".$x["TIAT_estado"];?>
                <tr>
                    <td><?php echo $x["TIAT_id"] ?></td>
                    <td><?php echo $x["TIAT_descripcion"] ?></td>
                    <td><center><a href="#"  data-bs-toggle="modal" data-bs-target="#modalTipoAtencionAct" onclick="llenarDatosTipoAtencion('<?php echo $datos ?>')"><i class="fas fa-edit text-dark"></i></a></center></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tablaTipoAtencion').DataTable({
            "info":false,
            "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
        });
    });
</script>
