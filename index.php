<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/general/loader.css">
</head>
<body style="background-color: rgba(0, 0, 0, 0.02);">
  <div class="loader-page"></div>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
       <div class="col-xs-5 col-lg-4 col-md-8 col-sm-12 card-login shadow bg-white p-3 rounded-3">
           <form class="d-flex flex-column" id="formLogin">
               <img src="assets/img/logo1.jpeg" class="mx-auto img-fluid" style="height: 320px;" alt="gyt">
               <!--  <MARQUEE class="mx-2 text-uppercase my-2"> INGRESE SU USUARIO Y CONTRASEÑA </MARQUEE> -->
              <div class="input-group mt-3 input-g">
                <span class="input-group-text" id="basic-addon1"><i class='bx bxs-user'></i></span>
                <input type="text" class="form-control" data-validate name="usuario" placeholder="Usuario" aria-label="Username" aria-describedby="basic-addon1"><br>
              </div>
              <div class="input-group mt-3">
                <span class="input-group-text verContra" id="basic-addon1"><a href="#" class="text-dark"><i class='bx bxs-low-vision'></i></a></span>
                <input type="password" id="verContra" data-validate name="contrasena" class="form-control" placeholder="Contraseña" aria-label="Username" aria-describedby="basic-addon1">
              </div>
              <?php require_once("php/conexion.php");
              $cedes = mysqli_query($conexion, "SELECT * FROM cedes WHERE CEDE_estado=1");
               ?>
              <div class="input-group mt-3">
                <span class="input-group-text verContra" id="basic-addon1"><a href="#" class="text-dark"><i class='bx bxs-home' ></i></a></span>
                <select class="form-select form-select-sm" data-validate="" name="cede">
                  <option value="" selected disabled>Seleccione una Comedor</option>
                  <?php foreach ($cedes as $x) : ?>
                      <option value="<?php echo $x["CEDE_id"] ?>"><?php echo $x["CEDE_descripcion"] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button class="btn btn-gray-gyt mt-3" id="envioLogin">Ingresar</button>
           </form>
       </div>
    </div>
    <script src="assets/js/login.js" type="module"></script>
    <script src="assets/js/globales.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>