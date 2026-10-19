<?php
/*
 * Controlador frontal: toda petición que no sea un archivo existente llega aquí (.htaccess).
 */
require __DIR__ . '/app/bootstrap.php';

use App\Nucleo\Enrutador;
use App\Nucleo\Solicitud;

$solicitud = Solicitud::desdeGlobales();
$rutas = require APP . '/config/rutas.php';

(new Enrutador($rutas['rutas'], $rutas['redirecciones']))->despachar($solicitud);
