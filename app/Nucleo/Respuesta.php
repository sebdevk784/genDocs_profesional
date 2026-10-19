<?php
declare(strict_types=1);

namespace App\Nucleo;

/**
 * Cabeceras HTTP comunes. Se envían desde PHP (y no desde .htaccess) porque así funcionan
 * aunque el hosting no tenga mod_headers.
 */
final class Respuesta
{
    public static function cabecerasSeguridad(): void
    {
        header('X-Content-Type-Options: nosniff');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('X-Frame-Options: DENY');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=(), interest-cohort=()');
        header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self'; "
            . "script-src 'self'; font-src 'self'; form-action 'self'; frame-ancestors 'none'; "
            . "base-uri 'self'; object-src 'none'");
    }

    public static function html(string $contenido, int $estado = 200): void
    {
        http_response_code($estado);
        header('Content-Type: text/html; charset=UTF-8');
        echo $contenido;
    }

    public static function redirigir(string $url, int $estado = 302): void
    {
        header('Location: ' . $url, true, $estado);
    }
}
