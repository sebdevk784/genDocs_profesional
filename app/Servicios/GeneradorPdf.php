<?php
declare(strict_types=1);

namespace App\Servicios;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Convierte el HTML de una plantilla de app/Vistas/pdf en un PDF descargable con dompdf.
 * - isRemoteEnabled=false: dompdf nunca descarga recursos externos (evita SSRF).
 * - chroot en la raíz del proyecto: solo puede leer archivos locales del sitio.
 * - Las imágenes del usuario llegan como data URI, nada se escribe en disco.
 */
final class GeneradorPdf
{
    public function descargar(string $html, string $nombreArchivo): void
    {
        $opciones = new Options();
        $opciones->set('chroot', RAIZ);
        $opciones->set('isRemoteEnabled', false);
        $opciones->set('isPhpEnabled', false);
        $opciones->set('defaultFont', 'Helvetica');
        $opciones->set('defaultPaperSize', 'letter');

        $dompdf = new Dompdf($opciones);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->render();
        $dompdf->stream($nombreArchivo, ['Attachment' => true]);
    }
}
