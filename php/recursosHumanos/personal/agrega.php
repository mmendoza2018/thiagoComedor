<?php 
session_start();
require_once("../../conexion.php");

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
$unidadMinera = @$_POST["unidadMinera"];
$cuentaCts = @$_POST["cuentaCts"];
$bancoCts = @$_POST["bancoCts"];
$tipoAfp = @$_POST["tipoAfp"];
$empresaIngresos5ta = @$_POST["empresaIngresos5ta"];
$vehiculoCancelado = @$_POST["vehiculoCancelado"];
$estadoTrabajo = @$_POST["estadoTrabajo"];


//conjunto de datos
$dataDerechoHaAdd = @$_POST["dataDerechoHaAdd"];
$dataEstudiosAdd = @$_POST["dataEstudiosAdd"];
$dataOtrosEstudiosAdd = @$_POST["dataOtrosEstudiosAdd"];
$dataExperienciaAdd = @$_POST["dataExperienciaAdd"];

$conPersona = "SELECT PER_id FROM personas WHERE PER_usuario=$numDocumento AND PER_estado = 1";
$resPersona = mysqli_query($conexion, $conPersona);
if (mysqli_num_rows($resPersona)>0) {
  echo json_encode([false,'Un Trabajador ya fue registrado con este DNI']);
  die();
}
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

$consulta = " INSERT INTO personas (
                                    UNMI_id01,
                                    PER_usuario, 
                                    PER_tipodoc, 	
                                    PER_nombres, 	
                                    PER_apellidos, 	
                                    PER_fecha_nacimiento, 		
                                    PER_departamento_nac, 	
                                    PER_provincia_nac, 	
                                    PER_distrito_nac, 		
                                    PER_correo, 		
                                    PER_estudios, 		
                                    PER_direccion, 	
                                    PER_referencia, 		
                                    PER_departamento, 	
                                    PER_provincia, 		
                                    PER_distrito, 	
                                    PER_telefono, 		
                                    PER_celular, 		
                                    PER_contacto, 		
                                    PER_derecho_habientes, 		
                                    PER_experiencia, 		
                                    PER_implementos, 		
                                    PER_otros_estudios, 		
                                    PER_sangre, 	
                                    PER_vivienda, 		
                                    PER_vehiculo, 		
                                    PER_vehiculo_pagado, 		
                                    PER_cuspp, 	
                                    PER_sis_pension, 
                                    PER_afp, 		
                                    PER_banco_sueldo, 		
                                    PER_banco_cts, 		
                                    PER_5ta_ingresos, 		
                                    PER_5ta_empresa, 		
                                    PER_5ta_adicional, 		
                                    PER_cuenta_sueldo, 	
                                    PER_cuenta_cts, 	
                                    PER_estado_trabajo,
                                    PER_loguser
                                    ) VALUES 
                                    (
                                      $unidadMinera,
                                     '$numDocumento',
                                     'DNI',
                                     '$nombres',
                                     '$apellidos',
                                     '$fechaNacimiento',
                                     '$departamentoNac',
                                     '$provinciaNac',
                                     '$distritoNac',
                                     '$correo',
                                     '$dataEstudiosAdd',
                                     '$direccion',
                                     '$referencia',
                                     '$departamentoAct',
                                     '$provinciaAct',
                                     '$distritoAct',
                                     '$telefono',
                                     '$celular',
                                     '$jsonContacto',
                                     '$dataDerechoHaAdd',
                                     '$dataExperienciaAdd',
                                     '$jsonImplementos',
                                     '$dataOtrosEstudiosAdd',
                                     '$sangre',
                                     '$casaActual',
                                     '$vehiculoPropio',
                                     '$vehiculoCancelado',
                                     '$cuspp',
                                     '$sistemaPensiones',
                                     '$tipoAfp',
                                     '$bancoSueldo',
                                     '$bancoCts',
                                     '$quintaCategoria1',
                                     '$empresaIngresos5ta',
                                     '$quintaCategoria2',
                                     '$cuentaSueldo',
                                     '$cuentaCts',
                                      $estadoTrabajo,
                                     'Administrador'
                                    )";
$resInsert = mysqli_query($conexion, $consulta);

echo ($resInsert) ? json_encode([true,null]) : json_encode([false,null]); 

$conexion->close();
?>