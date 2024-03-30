<?php
require_once 'vendor/autoload.php';
//instanciar clase de objeto Dompdf
use Dompdf\Dompdf;
//iniciar buffering de salida
ob_start();
//incluir template
require 'hoja_vida_template.php';
//guardar contenido del buffer en variable
$html = ob_get_clean();
// Obtén la ruta actual del archivo
$chroot = __DIR__;
// Crea una instancia de Dompdf con la configuración de chroot
$dompdf = new Dompdf(['chroot' => $chroot]);
$dompdf->setPaper('letter');
//se carga y renderiza el html
$dompdf->loadHtml($html);
$dompdf->render();
//se genera el pdf
$dompdf->stream("hoja_de_vida.pdf", array("Attachment" => true));
