<?php
session_start();
require_once("../../conexion.php");

$usuario = $_SESSION["datos_trabajador"][0]["nombres"];

$idPersona = @$_POST["idPersona"];
$idDocumento = @$_POST["idDocumento"];
$fechaInicio = @$_POST["fechaInicio"];
$fechaFin = (isset($_POST["fechaFin"])) ? $_POST["fechaFin"] : "0000-00-00";
$numerodoc = @$_POST["numerodoc"];
$descripcion = @$_POST["descripcion"];
$empresa = @$_POST["empresa"];
$observacion = @$_POST["observacion"];
$adjunto = @$_FILES["adjunto"];
$hoy = date("Y-m-d");

$nombreArchivo = "";

$claveAleatoria = md5($idPersona.$idDocumento.$descripcion);  // OR: generateRandomString(24)
$contenidoArchivo = file_get_contents($adjunto['tmp_name']); //contenido del archivo

$rutaDoc = "../../../archivos/"; // ruta del archivo
$nombreIdentificador = $idPersona . "-" . $claveAleatoria .$hoy. ".pdf";
$guardaDoc =  file_put_contents($rutaDoc.$nombreIdentificador, $contenidoArchivo);
if ($guardaDoc) {
    $consulta = "INSERT INTO documentos (
                                            PER_id01,
                                            TIDO_id01,
                                            DOCU_fecha_ingreso,
                                            DOCU_fecha_vencimiento,
                                            DOCU_numero,
                                            DOCU_descripcion,
                                            DOCU_empresa,
                                            DOCU_observacion,
                                            DOCU_nombre,
                                            DOCU_usuario
                                        ) VALUES
                                        (
                                            '$idPersona',
                                            '$idDocumento',
                                            '$fechaInicio',
                                            '$fechaFin',
                                            '$numerodoc',
                                            '$descripcion',
                                            '$empresa',
                                            '$observacion',
                                            '$nombreIdentificador',
                                            '$usuario'
                                        )";

    $resConAgregaDoc = mysqli_multi_query($conexion, $consulta);

    echo ($resConAgregaDoc) ? json_encode(true) : json_encode(false);
} else {
    echo json_encode(false); // ocurrio un error al subir el archivo
}
