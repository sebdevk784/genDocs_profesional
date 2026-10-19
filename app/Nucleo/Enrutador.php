<?php
declare(strict_types=1);

namespace App\Nucleo;

use App\Controladores\ErrorControlador;

/**
 * Resuelve "MÉTODO /ruta" contra la tabla de app/config/rutas.php y ejecuta el controlador.
 */
final class Enrutador
{
    private array $rutas;
    private array $redirecciones;

    public function __construct(array $rutas, array $redirecciones = [])
    {
        $this->rutas = $rutas;
        $this->redirecciones = $redirecciones;
    }

    public function despachar(Solicitud $solicitud): void
    {
        Respuesta::cabecerasSeguridad();
        Vista::compartir('solicitud', $solicitud);
        Vista::compartir('preferencias', Preferencias::desdeCookies($solicitud->cookies()));

        $ruta = $solicitud->ruta();
        if (isset($this->redirecciones[$ruta])) {
            Respuesta::redirigir(url($this->redirecciones[$ruta]), 301);
            return;
        }

        $destino = $this->rutas[$solicitud->metodo() . ' ' . $ruta] ?? null;
        if ($destino === null) {
            $permitidos = $this->metodosPara($ruta);
            $errores = new ErrorControlador($solicitud);
            if ($permitidos) {
                header('Allow: ' . implode(', ', $permitidos));
                $errores->metodoNoPermitido();
            } else {
                $errores->noEncontrado();
            }
            return;
        }

        [$clase, $accion] = $destino;
        (new $clase($solicitud))->$accion();
    }

    private function metodosPara(string $ruta): array
    {
        $metodos = [];
        foreach (array_keys($this->rutas) as $clave) {
            [$metodo, $patron] = explode(' ', $clave, 2);
            if ($patron === $ruta) {
                $metodos[] = $metodo;
            }
        }
        return $metodos;
    }
}
