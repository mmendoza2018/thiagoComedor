<?php
session_start();
require_once("../conexion.php");
date_default_timezone_set("America/Lima");
$horaActual = date('H:i:s');  
$fechaActual = date('Y-m-d');  

$idCedeSesion = $_SESSION['datos_trabajador'][0]["idCede"];
$dniComensal = $_POST["dniComensal"];
$idTipoComida = null;
$idTipoRegistro = 1; //registro hecho por el comensal
$idTipoAtencion = 1; //registro solo para consumos diarios

//verifica que el comensales este registrado
$resCodigo = mysqli_query($conexion,"SELECT COME_id FROM comensales WHERE COME_dni='$dniComensal'");
if (mysqli_num_rows($resCodigo) <= 0) {
  echo json_encode([false,'El trabajador no esta registrado en el sistema!']);
  die(); 
}

foreach ($resCodigo as $k) { $idComensal = $k["COME_id"]; }
$resHorarios = mysqli_query($conexion,"SELECT * FROM horarios h 
                                      LEFT JOIN tipo_alimentos ta ON h.TIAL_id01=ta.TIAL_id WHERE HORA_estado=1");
foreach ($resHorarios as $x) {
  $horaInicio = new DateTime($x['HORA_inicio']);
  $resHoraInicio = $horaInicio->format('H:i:s');
  $horaFinal = new DateTime($x['HORA_final']);
  $resHoraFinal = $horaFinal->format('H:i:s');
  if ($horaActual > $resHoraInicio && $horaActual < $resHoraFinal) {
    $idTipoComida = $x['TIAL_id01'];
    $precioTipoComida = $x['TIAL_precio'];
    break;
  }
}
//verifica que no haya duplicaciones de raciones
$conExisteRegistro = "SELECT DATE(REAL_fecha) FROM registros_alimentacion ra 
                      LEFT JOIN comensales c ON ra.COME_id01 = c.COME_id
                      WHERE DATE(REAL_fecha)='$fechaActual' AND COME_dni='$dniComensal' AND TIAL_id01='$idTipoComida'";
$ExisteRegistro = mysqli_query($conexion, $conExisteRegistro);
if (mysqli_num_rows($ExisteRegistro) > 0) {
  echo json_encode([false,'El trabajador ya recibio la ración diaria!']);
  die(); 
}
$consultaRegistro = "INSERT INTO registros_alimentacion 
                        (	
                          COME_id01,	
                          CEDE_id01,	
                          TIAL_id01,		
                          REAL_precio_comida,	
                          TIRE_id01,	
                          TIAT_id01
                        ) VALUES 
                        (
                          '$idComensal',
                          $idCedeSesion,
                          '$idTipoComida',
                          '$precioTipoComida',
                          $idTipoRegistro,
                          $idTipoAtencion
                        )";

echo (mysqli_query($conexion, $consultaRegistro)) 
? json_encode([true,'Registrado Correctamente']) 
: json_encode([false,'Ocurrio algun error!']);
mysqli_close($conexion);
