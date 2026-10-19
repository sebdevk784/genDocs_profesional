<?php
declare(strict_types=1);

namespace App\Nucleo;

/**
 * Petición HTTP actual: método, ruta relativa al sitio y datos enviados.
 * La ruta base se calcula a partir de SCRIPT_NAME, así el mismo código funciona en la raíz de
 * InfinityFree (/) y en una subcarpeta de XAMPP (/genDocs_profesional).
 */
final class Solicitud
{
    private static ?string $base = null;

    private string $metodo;
    private string $ruta;
    private array $post;
    private array $archivos;
    private array $cookies;

    public function __construct(string $metodo, string $ruta, array $post = [], array $archivos = [], array $cookies = [])
    {
        $this->metodo = strtoupper($metodo);
        $this->ruta = $ruta;
        $this->post = $post;
        $this->archivos = $archivos;
        $this->cookies = $cookies;
    }

    public static function desdeGlobales(): self
    {
        $ruta = rawurldecode((string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
        $base = self::base();
        if ($base !== '' && strncmp($ruta, $base, strlen($base)) === 0) {
            $ruta = substr($ruta, strlen($base));
        }
        $ruta = '/' . trim($ruta, '/');

        return new self($_SERVER['REQUEST_METHOD'] ?? 'GET', $ruta, $_POST, $_FILES, $_COOKIE);
    }

    /** Prefijo de la URL del sitio sin barra final ('' en producción). */
    public static function base(): string
    {
        if (self::$base === null) {
            $directorio = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
            self::$base = rtrim($directorio, '/.');
        }
        return self::$base;
    }

    public function metodo(): string
    {
        // HEAD se atiende como GET (los buscadores lo usan para comprobar páginas).
        return $this->metodo === 'HEAD' ? 'GET' : $this->metodo;
    }

    public function ruta(): string
    {
        return $this->ruta;
    }

    /** Texto enviado por POST, sin espacios sobrantes ni caracteres de control. */
    public function texto(string $clave, int $maximo = 0): string
    {
        return self::limpiar($this->post[$clave] ?? '', $maximo);
    }

    /** Arreglo de POST (campos con [] en el nombre). */
    public function arreglo(string $clave): array
    {
        $valor = $this->post[$clave] ?? [];
        return is_array($valor) ? $valor : [];
    }

    public function tiene(string $clave): bool
    {
        return isset($this->post[$clave]);
    }

    public function archivo(string $clave): ?array
    {
        $archivo = $this->archivos[$clave] ?? null;
        return is_array($archivo) && isset($archivo['error']) && !is_array($archivo['error']) ? $archivo : null;
    }

    public function cookies(): array
    {
        return $this->cookies;
    }

    public static function limpiar($valor, int $maximo = 0): string
    {
        if (!is_scalar($valor)) {
            return '';
        }
        $texto = (string) $valor;
        if (!mb_check_encoding($texto, 'UTF-8')) {
            return '';
        }
        $texto = preg_replace('/\r\n?/', "\n", $texto);
        $texto = preg_replace('/[\x00-\x09\x0B-\x1F\x7F]/', ' ', $texto);
        $texto = preg_replace(['/ {2,}/', '/ *\n */', '/\n{3,}/'], [' ', "\n", "\n\n"], $texto);
        $texto = trim($texto);
        return $maximo > 0 ? mb_substr($texto, 0, $maximo) : $texto;
    }
}
