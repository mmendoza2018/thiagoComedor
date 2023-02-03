<?php 
session_start();
require_once("../../conexion.php");

$id = @$_POST["id"];
$numDocumento = @$_POST["numDocumento"];
$nombres = @$_POST["nombres"];
$apellidos = @$_POST["apellidos"];
$fechaNacimiento = @$_POST["fechaNacimiento"];
$departamentoNac = @$_POST["departamentoNac"];
$provinciaNac = @$_POST["provinciaNac"];
$distritoNac = @$_POST["distritoNac"];
$sangre = @$_POST["sangre"];
$correo = @$_POST["correo"];
$telefono = @$_POST["telefono"];
$celular = @$_POST["celular"];
$telefonosEmergencia = @$_POST["telefonosEmergencia"];
$personaEmergencia = @$_POST["personaEmergencia"];
$personaParentesco = @$_POST["personaParentesco"];
$direccion = @$_POST["direccion"];
$referencia = @$_POST["referencia"];
$departamentoAct = @$_POST["departamentoAct"];
$provinciaAct = @$_POST["provinciaAct"];
$distritoAct = @$_POST["distritoAct"];
$tallaChaqueta = @$_POST["tallaChaqueta"];
$tallaCamisa = @$_POST["tallaCamisa"];
$tallaPantalon = @$_POST["tallaPantalon"];
$tallaZapatos = @$_POST["tallaZapatos"];
$casaActual = @$_POST["casaActual"];
$vehiculoPropio = @$_POST["vehiculoPropio"];
$sistemaPensiones = @$_POST["sistemaPensiones"];
$cuspp = @$_POST["cuspp"];
$quintaCategoria1 = @$_POST["quintaCategoria1"];
$quintaCategoria2 = @$_POST["quintaCategoria2"];
$cuentaSueldo = @$_POST["cuentaSueldo"];
$bancoSueldo = @$_POST["bancoSueldo"];
$cuentaCts = @$_POST["cuentaCts"];
$bancoCts = @$_POST["bancoCts"];
$tipoAfp = @$_POST["tipoAfp"];
$empresaIngresos5ta = @$_POST["empresaIngresos5ta"];
$vehiculoCancelado = @$_POST["vehiculoCancelado"];

//conjunto de datos
$dataDerechoHaAct = @$_POST["dataDerechoHaAct"];
$dataEstudiosAct = @$_POST["dataEstudiosAct"];
$dataOtrosEstudiosAct = @$_POST["dataOtrosEstudiosAct"];
$dataExperienciaAct = @$_POST["dataExperienciaAct"];

//json contacto
$jsonContacto = json_encode(
  [
    "telefonos" => $telefonosEmergencia,
    "persona" => $personaEmergencia,
    "parentesco" => $personaParentesco
  ]
  );
//json implementos
$jsonImplementos = json_encode(
  [
    "chaqueta" => $tallaChaqueta,
    "camisa" => $tallaCamisa,
    "pantalon" => $tallaPantalon,
    "zapatos" => $tallaZapatos
  ]
  );

$consulta = " UPDATE personas SET 
                                    PER_usuario = '$numDocumento', 
                                    PER_nombres = '$nombres',	
                                    PER_apellidos = '$apellidos',	
                                    PER_fecha_nacimiento = '$fechaNacimiento', 		
                                    PER_departamento_nac = '$departamentoNac', 	
                                    PER_provincia_nac = '$provinciaNac', 	
                                    PER_distrito_nac = '$distritoNac', 		
                                    PER_correo = '$correo', 		
                                    PER_estudios = '$dataEstudiosAct', 		
                                    PER_direccion = '$direccion', 	
                                    PER_referencia = '$referencia', 		
                                    PER_departamento = '$departamentoAct', 	
                                    PER_provincia = '$provinciaAct', 		
                                    PER_distrito = '$distritoAct', 	
                                    PER_telefono = '$telefono', 		
                                    PER_celular = '$celular', 		
                                    PER_contacto = '$jsonContacto', 		
                                    PER_derecho_habientes = '$dataDerechoHaAct', 		
                                    PER_experiencia = '$dataExperienciaAct', 		
                                    PER_implementos = '$jsonImplementos', 		
                                    PER_otros_estudios = '$dataOtrosEstudiosAct', 		
                                    PER_sangre = '$sangre', 	
                                    PER_vivienda = '$casaActual', 		
                                    PER_vehiculo = '$vehiculoPropio', 		
                                    PER_vehiculo_pagado = '$vehiculoCancelado', 		
                                    PER_cuspp = '$cuspp', 	
                                    PER_sis_pension = '$sistemaPensiones', 
                                    PER_afp = '$tipoAfp', 		
                                    PER_banco_sueldo = '$bancoSueldo', 		
                                    PER_banco_cts = '$bancoCts', 		
                                    PER_5ta_ingresos = '$quintaCategoria1', 		
                                    PER_5ta_empresa = '$empresaIngresos5ta', 		
                                    PER_5ta_adicional = '$quintaCategoria2', 		
                                    PER_cuenta_sueldo = '$cuentaSueldo', 	
                                    PER_cuenta_cts = '$cuentaCts'
                                    WHERE PER_id = $id";

$resUpdate = mysqli_query($conexion, $consulta);

echo ($resUpdate) ? json_encode(true) : json_encode(false); 

$conexion->close();
?>