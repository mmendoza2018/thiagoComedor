<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require '../../../assets/plugins/phpMailer/Exception.php';
require '../../../assets/plugins/phpMailer/PHPMailer.php';
require '../../../assets/plugins/phpMailer/SMTP.php';
require_once("../../conexion.php");
error_reporting(0);
$idsDocEquipos= json_decode($_POST["docsEquipos"]);
$newDocumentos = [];

foreach ($idsDocEquipos as $key => $value) {
    $newDocumentos[$key] = [] ;
    foreach ($value as $key2 => $value2) {
        $array = json_decode(json_encode($value2), true);
        $consulta  = "SELECT DOCU_descripcion, DOCU_nombre,TIDO_descripcion FROM documentos do 
                      INNER JOIN tipo_documentos td ON do.TIDO_id01 = td.TIDO_id WHERE DOCU_id= '".$array["id"]."'";
        $arrayDocumento = mysqli_fetch_assoc(mysqli_query($conexion, $consulta));
        
        $ruta = "../../../archivos/".$arrayDocumento["DOCU_nombre"];
        $array["ruta"] = $ruta;
        array_push($newDocumentos[$key], $array);
   
}
}

 envio_pdf($newDocumentos);
function envio_pdf($datoEquipos){

$mail = new PHPMailer(true);

try {
$correo= @$_POST["correo"];
$asunto= $_POST["asunto"]=="" ? "" :$_POST["asunto"];
    //Server settings
    $mail->SMTPDebug = 0;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'sistema.sgthiagoaris.com';                    // host de quien va brindar el servicio
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'sistema@sgthiagoaris.com';                     // SMTP username
    $mail->Password   = 'sistemaEmail2022Thiago';                               // SMTP password
    $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    //Recipients
    $mail->setFrom('sistema@sgthiagoaris.com', 'sgthiagoaris');
    $mail->addAddress($correo);     // Add a recipient

    // Attachments
    foreach ($datoEquipos as $key => $value) {
        foreach ($value as $key2 => $value2) {
            $titleDocument = $key . ' | ' . $value2['documento'];
            $mail->AddAttachment($value2['ruta'],$titleDocument,"base64","application/pdf");
        }
    }
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'GYT Archivos Adjuntos';
    $mail->Body    = $asunto;

    $mail->send();
    echo json_encode(true);
} catch (Exception $e) {
    echo json_encode(false);
}
}
?>