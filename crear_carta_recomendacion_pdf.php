<?php
require_once 'vendor/autoload.php';
//instanciar clase de objeto Dompdf
use Dompdf\Dompdf;
//instanciar buffering de salida
ob_start();
//incluir template
require  'carta_recomendacion_template.php';
//se guarda el contenido del buffer en variable
$html = ob_get_clean();
//se obtiene la ruta del archivo
$chroot = __DIR__;
//se instancia la clase Dompdf y se le pasa la configuracion chroot
$dompdf = new Dompdf(['chroot' => $chroot]);
//se establece el tamaño de papel
$dompdf->setPaper('letter');
//se carga y renderiza el html
$dompdf->loadHtml($html);
$dompdf->render();
//se genera el pdf descargable
$dompdf->stream("carta_recomendacion_personal.pdf", array("Attachment" => true));
