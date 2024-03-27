<?php

require_once 'vendor/autoload.php';

use Dompdf\Dompdf;

ob_start();
require  'carta_recomendacion_template.php';
$html = ob_get_clean();
$chroot = __DIR__;
$dompdf = new Dompdf(['chroot' => $chroot]);
$dompdf->setPaper('letter');
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("carta_recomendacion_personal.pdf", array("Attachment" => true));
