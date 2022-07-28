<?php
include_once("../../conexion.php");
$conTipoEquipo = mysqli_query($conexion, "SELECT * FROM EMPRESAS WHERE EMPR_estado=1");
?>
<div class="table-responsive">
    <table id="tablaMotivoSalida" class="table table-striped">
        <thead>
            <tr>
                <th>Nro</th>
                <th>RUC</th>
                <th>Razon Social</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($conTipoEquipo as $x) : 
            $datos = $x["EMPR_id"]."|".$x["EMPR_razonSocial"]."|".$x["EMPR_ruc"]."|".$x["EMPR_estado"];?>
                <tr>
                    <td><?php echo $x["EMPR_id"] ?></td>
                    <td><?php echo $x["EMPR_ruc"] ?></td>
                    <td><?php echo $x["EMPR_razonSocial"] ?></td>
                    <td><center><a href="#"  data-bs-toggle="modal" data-bs-target="#modalEmpresasAct" onclick="llenarDatosEmpresas('<?php echo $datos ?>')"><i class="fas fa-edit text-dark"></i></a></center></td>
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
