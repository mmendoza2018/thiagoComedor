<?php
include_once("../../conexion.php");
$conTipoEquipo = mysqli_query($conexion, "SELECT * FROM tipo_alimentos WHERE TIAL_estado=1");
?>
<div class="table-responsive">
    <table id="tablaMotivoSalida" class="table table-striped">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Unidad</th>
                <th>Precio</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($conTipoEquipo as $x) : 

            $datos = $x["TIAL_id"]."|".$x["TIAL_descripcion"]."|".$x["TIAL_marca"]."|".$x["TIAL_unidad"]."|".$x["TIAL_precio"]."|".$x["TIAL_principal"]."|".$x["TIAL_usuario"]."|".$x["TIAL_estado"];?>
                <tr>
                    <td><?php echo $x["TIAL_id"] ?></td>
                    <td><?php echo $x["TIAL_descripcion"] ?></td>
                    <td><?php echo $x["TIAL_marca"] ?></td>
                    <td><?php echo $x["TIAL_unidad"] ?></td>
                    <td><?php echo $x["TIAL_precio"] ?></td>
                    <td><center><a href="#"  data-bs-toggle="modal" data-bs-target="#modalAlimentoAct" onclick="llenarDatosAlimentos('<?php echo $datos ?>')"><i class="fas fa-edit text-dark"></i></a></center></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tablaMotivoSalida').DataTable({
            "info":false,
            "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
        });
    });
</script>
