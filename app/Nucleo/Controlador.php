<?php
declare(strict_types=1);

namespace App\Nucleo;

abstract class Controlador
{
    protected Solicitud $solicitud;

    public function __construct(Solicitud $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    protected function mostrar(string $vista, array $datos = [], int $estado = 200): void
    {
        Respuesta::html(Vista::render($vista, $datos), $estado);
    }
}
