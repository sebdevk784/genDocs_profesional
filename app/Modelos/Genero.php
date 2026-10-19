<?php
declare(strict_types=1);

namespace App\Modelos;

/**
 * Género gramatical con el que se redacta un documento.
 * Las plantillas piden la forma de cada palabra con segun('identificado', 'identificada').
 * Si no se especifica (solo se permite para el destinatario de una carta), se usa la forma
 * con «(a)» que el sitio usaba antes.
 */
final class Genero
{
    public const HOMBRE = 'hombre';
    public const MUJER = 'mujer';

    private string $valor;

    public function __construct(string $valor)
    {
        $this->valor = self::esValido($valor) ? $valor : '';
    }

    public static function opciones(): array
    {
        return [self::HOMBRE => 'Hombre', self::MUJER => 'Mujer'];
    }

    public static function esValido(string $valor): bool
    {
        return $valor === self::HOMBRE || $valor === self::MUJER;
    }

    public function especificado(): bool
    {
        return $this->valor !== '';
    }

    public function segun(string $masculino, string $femenino, ?string $sinEspecificar = null): string
    {
        if ($this->valor === self::MUJER) {
            return $femenino;
        }
        if ($this->valor === self::HOMBRE) {
            return $masculino;
        }
        return $sinEspecificar ?? $masculino . '(a)';
    }
}
