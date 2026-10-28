<?php
declare(strict_types=1);

namespace App\Nucleo;

/**
 * Preferencias de visualización (tema y tamaño de letra) guardadas en cookies.
 * El servidor las aplica al generar el HTML, por eso funcionan sin JavaScript y sin parpadeo.
 * Sin cookie de tema, el CSS sigue la preferencia del sistema operativo.
 */
final class Preferencias
{
    public const TEMAS = ['claro' => 'light', 'oscuro' => 'dark'];
    public const FUENTE_MINIMA = 1;
    public const FUENTE_NORMAL = 2;
    public const FUENTE_MAXIMA = 5;

    private ?string $tema;
    private int $fuente;

    public function __construct(?string $tema = null, int $fuente = self::FUENTE_NORMAL)
    {
        // Se descarta null antes de usarlo como índice: PHP 8.5 lo marca como obsoleto.
        $this->tema = $tema !== null && isset(self::TEMAS[$tema]) ? $tema : null;
        $this->fuente = max(self::FUENTE_MINIMA, min(self::FUENTE_MAXIMA, $fuente));
    }

    public static function desdeCookies(array $cookies): self
    {
        $nombres = Config::obtener('cookies');
        $tema = $cookies[$nombres['tema']] ?? null;
        $fuente = $cookies[$nombres['fuente']] ?? null;
        return new self(
            is_string($tema) ? $tema : null,
            is_string($fuente) && ctype_digit($fuente) ? (int) $fuente : self::FUENTE_NORMAL
        );
    }

    /** Valor de data-theme para <html> ('light', 'dark' o null para seguir al sistema). */
    public function temaHtml(): ?string
    {
        return $this->tema === null ? null : self::TEMAS[$this->tema];
    }

    public function fuente(): int
    {
        return $this->fuente;
    }

    public function puedeReducir(): bool
    {
        return $this->fuente > self::FUENTE_MINIMA;
    }

    public function puedeAumentar(): bool
    {
        return $this->fuente < self::FUENTE_MAXIMA;
    }

    /** Aplica la acción de un botón: tema=claro|oscuro o fuente=menos|normal|mas. */
    public function aplicar(?string $tema, ?string $fuente): self
    {
        $nuevoTema = $tema !== null && isset(self::TEMAS[$tema]) ? $tema : $this->tema;
        switch ($fuente) {
            case 'menos':
                $nuevaFuente = $this->fuente - 1;
                break;
            case 'mas':
                $nuevaFuente = $this->fuente + 1;
                break;
            case 'normal':
                $nuevaFuente = self::FUENTE_NORMAL;
                break;
            default:
                $nuevaFuente = $this->fuente;
        }
        return new self($nuevoTema, $nuevaFuente);
    }

    public function guardar(): void
    {
        $nombres = Config::obtener('cookies');
        $opciones = [
            'expires' => time() + 86400 * (int) $nombres['duracion_dias'],
            'path' => Solicitud::base() . '/',
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => false, // el script de mejora progresiva también las actualiza
            'samesite' => 'Lax',
        ];
        if ($this->tema !== null) {
            setcookie($nombres['tema'], $this->tema, $opciones);
        }
        setcookie($nombres['fuente'], (string) $this->fuente, $opciones);
    }
}
