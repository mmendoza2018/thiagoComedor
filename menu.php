<?php 
session_start();
if ($_SESSION["datos_trabajador"][0]){ ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "componentes/header.html" ?>
    <title>menu principal</title>
</head>
<body class="fondo-global">
    <div id="PW_general" class="page-wrapper toggled ice-theme">
        <?php include_once("componentes/sidebar.php") ?>
        <!-- page-content  -->
        <main class="container-fluid page-content fondo-global pt-0">
            <div id="overlay" class="overlay"></div>
            <div class="loader-page"></div>
                <nav class="navbar navbar-light bg-white shadow d-flex justify-content-between d-md-none py-0">
                <a href="php/cerrar_sesion.php" class="text-danger ms-2"><i class="fas fa-reply-all"></i></a>
                    <a id="toggle-sidebar" class="btn float-end" href="#"> <i class="fas fa-bars"></i> </a>
                    <!-- <a id="toggle-sidebar" class="btn" href="#"> <i class="fas fa-undo-alt"></i> </a> -->
                </nav>
            <!-- contenido principal -->
            <div class="container-fluid px-0 pt-2" id="contenido"> </div>
        </main>
        <div id="modales"></div>
        <div id="estadoIngresoSistema" data-estado_sis="<?php echo $_SESSION["datos_trabajador"][0]["estado"] ?>"></div>
        <!-- page-content" -->
    </div>
    <?php 
    $_SESSION["datos_trabajador"][0]["estado"] = false;
    include "componentes/footer.html" 
    ?>
</body>
</html>
<?php } else header("Location: index.html"); ?>