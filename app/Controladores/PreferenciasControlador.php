<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Nucleo\Controlador;
use App\Nucleo\Preferencias;
use App\Nucleo\Respuesta;

/**
 * Guarda el tema y el tamaño de letra elegidos con los botones de la cabecera y regresa a la
 * página de origen (patrón POST → redirección → GET). Con JavaScript activo, app.js hace lo
 * mismo sin recargar la página y este controlador no se usa.
 */
final class PreferenciasControlador extends Controlador
{
    public function guardar(): void
    {
        Preferencias::desdeCookies($this->solicitud->cookies())->aplicar($this->solicitud->texto('tema', 10), $this->solicitud->texto('fuente', 10))->guardar();

        Respuesta::redirigir(url($this->rutaDeRegreso()), 303);
    }

    /** Solo se aceptan rutas internas para evitar redirecciones abiertas. */
    private function rutaDeRegreso(): string
    {
        $volver = $this->solicitud->texto('volver', 200);
        if ($volver === '' || $volver[0] !== '/' || strpos($volver, '//') !== false || strpos($volver, '\\') !== false) {
            return '/';
        }
        return (string) preg_replace('/[^A-Za-z0-9\/\-_#]/', '', $volver);
    }
}
