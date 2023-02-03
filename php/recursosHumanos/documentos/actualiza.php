<?php
session_start();
require("../../conexion.php");

$usuario = $_SESSION["datos_trabajador"][0]["nombres"];

$idDocumento = @$_POST["idDocumento"];
$idPersona = @$_POST["idPersona"];
$idTipoDocumento = @$_POST["idTipoDocumento"];
$fInicio = @$_POST["fInicio"];
$fFin = isset($_POST["fFin"]) ? $_POST["fFin"] : "0000-00-00"; ;
$numero = @$_POST["numero"];
$descripcion = @$_POST["descripcion"];
$empresa = @$_POST["empresa"];
$observaciones = @$_POST["observaciones"];
$estado = @$_POST["estado"];
$equipoAct=@$_POST["equipoAct"];
$descripcion = @$_POST["descripcion"];

$tipoDocumento="";
$identificadorDoc = "";

$datosDocumento = "SELECT DOCU_nombre FROM documentos WHERE DOCU_id='$idDocumento'";
$resDatosDocumento = mysqli_query($conexion, $datosDocumento);
foreach ($resDatosDocumento as $x) {
  $identificadorDoc = $x["DOCU_nombre"];
}
if ($_FILES['documento']['name']!=null) {

  $arrayIdentificador = explode(".", $identificadorDoc);
  $nuevoNombreArchivo = $arrayIdentificador[0] . "K" . "." . $arrayIdentificador[1];

  $ruta_doc_act = "../../../archivos/" . $identificadorDoc; // ruta del archivo
  if (file_exists($ruta_doc_act)) {
    unlink($ruta_doc_act); //eliminamos el archivo 
  }
  $contenidoArchivo = file_get_contents($_FILES["documento"]['tmp_name']); //contenido del archivo
  $guarda_doc =  file_put_contents("../../../archivos/" . $nuevoNombreArchivo, $contenidoArchivo);
  if(!$guarda_doc) {
    echo json_encode(false);
    die();
  };
  $identificadorDoc=$nuevoNombreArchivo;
}
$consulta = "UPDATE documentos SET 
                                          PER_id01 = '$idPersona',
                                          TIDO_id01 = '$idTipoDocumento',	
                                          DOCU_fecha_ingreso = '$fInicio',		
                                          DOCU_fecha_vencimiento = '$fFin',		
                                          DOCU_numero = '$numero',		
                                          DOCU_descripcion = '$descripcion',	
                                          DOCU_empresa = '$empresa',	
                                          DOCU_observacion = '$observaciones',	
                                          DOCU_nombre = '$identificadorDoc',	
                                          DOCU_usuario = '$usuario'
                                          WHERE DOCU_id='$idDocumento'";

echo (mysqli_query($conexion,$consulta)) ? json_encode(true) : json_encode(false);
$conexion->close();
?>
