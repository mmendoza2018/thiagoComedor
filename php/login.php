<?php
session_start();
require("conexion.php");

if ($_POST['usuario'] !== "" && $_POST['contrasena'] !== "" && $_POST['cede'] !== "") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $cede = $_POST['cede'];
    $contrasenaSql= "";
    $nombreSql = "";

    $sentencia = $conexion->prepare("SELECT USU_dni,USU_contrasenia,USU_nombres,USU_id FROM usuarios WHERE USU_dni = ? ");
    $sentencia->bind_param("s", $usuario);
    $sentencia->execute();
    $res = $sentencia->get_result();
    $filas = $res->num_rows;
    foreach ($res as $k) {
        $contrasenaSql = $k["USU_contrasenia"];
        $nombreSql = $k["USU_nombres"];
        $idUsuario = $k["USU_id"];
        $dniUsuario = $k["USU_dni"];
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
            echo 1; // hay similitud con las contaseñasS
            $_SESSION['datos_trabajador'][] = [
                "nombres"=> $nombreSql,
                "id"=> $idUsuario,
                "cede"=>$cede,
                "estado"=>true
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
