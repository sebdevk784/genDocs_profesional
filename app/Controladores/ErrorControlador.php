<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Nucleo\Controlador;

final class ErrorControlador extends Controlador
{
    public function noEncontrado(): void
    {
        $this->mostrar('errores/error', [
            'codigo' => 404,
            'titulo' => 'No encontramos esta página',
            'mensaje' => 'Es posible que el enlace haya cambiado. Elige el documento que necesitas:',
            'seo' => ['titulo' => 'Página no encontrada | GenDocs', 'ruta' => null, 'indexar' => false],
        ], 404);
    }

    public function errorInterno(): void
    {
        $this->mostrar('errores/error', [
            'codigo' => 500,
            'titulo' => 'No pudimos generar tu PDF',
            'mensaje' => 'Ocurrió un problema al crear el documento. Vuelve a intentarlo; si usaste una foto, prueba con una imagen JPG. Tus datos no se guardaron.',
            'seo' => ['titulo' => 'Error al generar el PDF | GenDocs', 'ruta' => null, 'indexar' => false],
        ], 500);
    }

    public function metodoNoPermitido(): void
    {
        $this->mostrar('errores/error', [
            'codigo' => 405,
            'titulo' => 'Acción no disponible',
            'mensaje' => 'Esta dirección no admite esa acción. Vuelve a abrir el formulario del documento:',
            'seo' => ['titulo' => 'Acción no disponible | GenDocs', 'ruta' => null, 'indexar' => false],
        ], 405);
    }
}
