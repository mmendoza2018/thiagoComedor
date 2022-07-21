<?php 
session_start();
require_once("../../../assets/plugins/mpdf/vendor/autoload.php"); 
require("plantilla.php");
require("../../conexion.php");
 $idOrden= $_GET["idOrden"];

    $css=file_get_contents("../style.css");
    $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch']);
    $mpdf->WriteHTML($css ,\Mpdf\HTMLParserMode::HEADER_CSS);
    $plantillaHecha=plantilla($idOrden);
    $mpdf->SetHTMLHeader($plantillaHecha[1], "O", true);
    $mpdf->SetHTMLFooter($plantillaHecha[2], "O");
    $mpdf->WriteHTML($plantillaHecha[0] ,\Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("ORDEN #".$idOrden.".pdf","I");
    /* style=" border:solid; border-color:blue; margin-bottom:50px" */
?>