<?php



//echo $html;
require_once 'vendor/autoload.php';
//instanciar clase de objeto
use Dompdf\Dompdf;

//iniciar buffering de salida
ob_start();
//incluir template
require 'carta_renuncia_template.php';
//guardar contenido del buffer en variable
$html = ob_get_clean();
// Obtén la ruta actual del archivo
$chroot = __DIR__;

// Crea una instancia de Dompdf con la configuración de chroot
$dompdf = new Dompdf(['chroot' => $chroot]);

$dompdf->setPaper('letter');
$dompdf->loadHtml($html);
$dompdf->render();
//echo $dompdf->output();
$dompdf->stream("carta_renuncia.pdf", array("Attachment" => true));
