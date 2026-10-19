<?php
declare(strict_types=1);

namespace App\Nucleo;

/**
 * Acceso de solo lectura a app/config/app.php con notación de puntos: Config::obtener('autor.nombre').
 */
final class Config
{
    private static array $valores = [];

    public static function cargar(array $valores): void
    {
        self::$valores = $valores;
    }

    public static function obtener(string $clave, $defecto = null)
    {
        $valor = self::$valores;
        foreach (explode('.', $clave) as $parte) {
            if (!is_array($valor) || !array_key_exists($parte, $valor)) {
                return $defecto;
            }
            $valor = $valor[$parte];
        }
        return $valor;
    }
}
