<?php
include_once("../../conexion.php");
$conTipoEquipo = mysqli_query($conexion, "SELECT * FROM tipo_documentos WHERE TIDO_estado = 1");
?>
<div class="table-responsive">
    <table id="tablaTipoDoc" class="table table-striped">
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
            $datos = $x["TIDO_id"]."|".$x["TIDO_descripcion"];?>
                <tr>
                    <td><?php echo $x["TIDO_id"] ?></td>
                    <td><?php echo $x["TIDO_descripcion"] ?></td>
                    <td><a href="#"  data-bs-toggle="modal" data-bs-target="#modalTipoDocEquipoAct" onclick="llenarTipoDocumento('<?php echo $datos ?>')"><i class="fas fa-edit text-dark""></i></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tablaTipoDoc').DataTable({
            "info":false,
            "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
        });
    });
</script>
