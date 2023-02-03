<?php
session_start();
require("conexion.php");

if ($_POST['usuario'] != "" && $_POST['contrasena'] != "" && $_POST['cede'] != "") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $cede = $_POST['cede'];
    $cedeNombre = $_POST['cedeNombre'];
    $contrasenaSql= "";
    $nombreSql = "";

    $sentencia = $conexion->prepare("SELECT PER_id,PER_contrasenia,CONCAT(PER_nombres, ' ', PER_apellidos) as nombres, PER_usuario FROM personas WHERE PER_usuario = ? ");
    $sentencia->bind_param("s", $usuario);
    $sentencia->execute();
    $res = $sentencia->get_result();
    $filas = $res->num_rows;
    foreach ($res as $k) {
        $contrasenaSql = $k["PER_contrasenia"];
        $nombreSql = $k["nombres"];
        $idUsuario = $k["PER_id"];
        $dniUsuario = $k["PER_usuario"];
        # code...
    }
    if ($filas !== 0) {
        if (password_verify($contrasena, $contrasenaSql)) {
            //verificar si tiene rol en el sistema 
            /* $con_rol="SELECT * FROM roles_persona WHERE USU_id01='$idUsuario'";
            $res_con_rol=mysqli_query($conexion,$con_rol);
            foreach ($res_con_rol as $y) { $rolUsuario = $y["ROL_id01"]; }
            if($res_con_rol->num_rows<=0){
                echo 0;
                return;
            } */
            echo 1; // hay similitud con las contaseñas
            $_SESSION['datos_trabajador'][] = [
                "nombres"=> $nombreSql,
                "id"=> $idUsuario,
                "idCede"=>$cede,
                "cedeNombre"=>$cedeNombre,
                "estado"=>1
            ];

        } else {
            echo 3; // la contra esta mal   
        }
    } else {
        echo 2; //  user esta mal
    }
} else {
    echo 4; //ausencia de datos
}
