<?php
declare(strict_types=1);

namespace App\Nucleo;

/**
 * Motor de vistas en PHP plano: cada vista es un archivo de app/Vistas que recibe sus datos
 * como variables. La plantilla recibe el HTML de la vista en $contenido.
 */
final class Vista
{
    private static array $compartidos = [];

    public static function compartir(string $clave, $valor): void
    {
        self::$compartidos[$clave] = $valor;
    }

    public static function render(string $vista, array $datos = [], ?string $plantilla = 'plantillas/base'): string
    {
        $datos += self::$compartidos;
        $contenido = self::incluir($vista, $datos);
        if ($plantilla === null) {
            return $contenido;
        }
        return self::incluir($plantilla, ['contenido' => $contenido] + $datos);
    }

    /** Fragmento reutilizable dentro de otra vista. */
    public static function parcial(string $vista, array $datos = []): string
    {
        return self::incluir($vista, $datos + self::$compartidos);
    }

    private static function incluir(string $__vista, array $__datos): string
    {
        extract($__datos, EXTR_SKIP);
        ob_start();
        require APP . '/Vistas/' . $__vista . '.php';
        return (string) ob_get_clean();
    }
}
