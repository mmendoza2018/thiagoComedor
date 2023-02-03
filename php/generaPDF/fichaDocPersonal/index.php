<?php
session_start();
require_once("../../../assets/plugins/mpdf/vendor/autoload.php");
require("plantilla.php");
$fecha = date("d:m:y");

$idPersona = @$_GET["id"];
$plantilla = plantilla($idPersona);
$mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch','setAutoBottomMargin'=>'stretch', 'margin_footer' => 2]);
$css = file_get_contents("../style.css");
$mpdf->WriteHTML($css, 1);
$mpdf->SetHTMLHeader($plantilla[1], "O", false);
$mpdf->SetHTMLFooter($plantilla[2], 'O');
$mpdf->WriteHTML($plantilla[0]);
$mpdf->Output($plantilla[3], "I");
