<?php
include_once("../../conexion.php");
$conAreas = mysqli_query($conexion, "SELECT * FROM areas WHERE AREA_estado=1");
?>
<div class="table-responsive">
    <table id="tablaComedores" class="table table-striped">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Descripción</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($conAreas as $x) : 
            $datos = $x["AREA_id"]."|".$x["AREA_descripcion"];?>
                <tr>
                    <td><?php echo $x["AREA_id"] ?></td>
                    <td><?php echo $x["AREA_descripcion"] ?></td>
                    <td><center><a href="#"  data-bs-toggle="modal" data-bs-target="#modalCargosAct" onclick="llenarDatosCargo('<?php echo $datos ?>')"><i class="fas fa-edit text-dark"></i></a></center></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tablaComedores').DataTable({
            "info":false,
            "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
        });
    });
</script>
