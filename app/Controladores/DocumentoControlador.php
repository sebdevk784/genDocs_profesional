<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Modelos\Documento;
use App\Nucleo\Controlador;
use App\Nucleo\Vista;
use App\Servicios\GeneradorPdf;

/**
 * Flujo común de los tres documentos:
 *   GET  → formulario vacío.
 *   POST → si los datos son válidos, descarga el PDF; si no, vuelve a mostrar el formulario
 *          con los errores (HTTP 422) y lo ya escrito.
 */
abstract class DocumentoControlador extends Controlador
{
    /** Vista del formulario y de la plantilla PDF (mismo nombre en formularios/ y pdf/). */
    abstract protected function vista(): string;

    abstract protected function nuevoDocumento(): Documento;

    abstract protected function documentoEnviado(): Documento;

    abstract protected function seo(): array;

    abstract protected function nombreArchivo(Documento $documento): string;

    public function formulario(): void
    {
        $this->mostrarFormulario($this->nuevoDocumento());
    }

    public function generar(): void
    {
        $documento = $this->documentoEnviado();
        if (!$documento->esValido()) {
            $this->mostrarFormulario($documento, 422);
            return;
        }
        $html = Vista::render($this->vistaPdf($documento), ['documento' => $documento], null);
        try {
            (new GeneradorPdf())->descargar($html, $this->nombreArchivo($documento));
        } catch (\Throwable $error) {
            // Un fallo de dompdf (por ejemplo, una extensión que falta en el servidor) no debe
            // mostrar un error de PHP: se registra y el usuario ve una página clara.
            error_log('GenDocs: no se pudo generar el PDF: ' . $error->getMessage());
            (new ErrorControlador($this->solicitud))->errorInterno();
        }
    }

    /** Plantilla PDF; los documentos con varios diseños la eligen según los datos. */
    protected function vistaPdf(Documento $documento): string
    {
        return 'pdf/' . $this->vista();
    }

    protected function mostrarFormulario(Documento $documento, int $estado = 200): void
    {
        $this->mostrar('formularios/' . $this->vista(), [
            'documento' => $documento,
            'seo' => $this->seo(),
        ], $estado);
    }
}
