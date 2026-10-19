<?php
declare(strict_types=1);

namespace App\Modelos;

use DateTimeImmutable;

/**
 * Fechas en formato ISO (lo que envía <input type="date">) y su redacción en español.
 */
final class Fecha
{
    private const MESES = [
        'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
        'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre',
    ];

    public static function crear(string $iso): ?DateTimeImmutable
    {
        $fecha = DateTimeImmutable::createFromFormat('!Y-m-d', $iso);
        return $fecha && $fecha->format('Y-m-d') === $iso ? $fecha : null;
    }

    public static function esValida(string $iso): bool
    {
        return self::crear($iso) !== null;
    }

    /** '2024-04-04' => '4 de abril de 2024' */
    public static function larga(string $iso): string
    {
        $fecha = self::crear($iso);
        if ($fecha === null) {
            return '';
        }
        return $fecha->format('j') . ' de ' . self::MESES[(int) $fecha->format('n') - 1] . ' de ' . $fecha->format('Y');
    }

    public static function hoy(): string
    {
        return (new DateTimeImmutable('today'))->format('Y-m-d');
    }
}
