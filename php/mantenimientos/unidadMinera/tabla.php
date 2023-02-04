<?php
include_once("../../conexion.php");
$conUnidadMinera = mysqli_query($conexion, "SELECT * FROM unidad_minera WHERE UNMI_estado = 1");

?>
<div class="table-responsive">
    <table id="tablaUnidadMinera" class="table table-striped">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Descripción</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($conUnidadMinera as $x) :
                $datos = $x["UNMI_id"] . "|" . $x["UNMI_descripcion"]; ?>
                <tr>
                    <td><?php echo $x["UNMI_id"] ?></td>
                    <td><?php echo $x["UNMI_descripcion"] ?></td>
                    <td><a href="#" data-bs-toggle="modal" data-bs-target="#modalUnidadMinera" onclick="llenarUnidadMinera('<?php echo $datos ?>')"><i class="fas fa-edit text-dark""></i></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tablaUnidadMinera').DataTable({
            "info":false, 
            "language" : { "url" : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" } 
        }); 
    }); 
</script>