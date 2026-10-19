<?php
/*
 * Arranque de la aplicación: constantes, manejo de errores, cargador de clases y ayudantes.
 * No usa Composer para las clases propias: así el proyecto se sube a InfinityFree tal cual,
 * sin regenerar vendor/ (Composer solo aporta dompdf).
 */
declare(strict_types=1);

define('RAIZ', dirname(__DIR__));
define('APP', __DIR__);

$config = require APP . '/config/app.php';

$host = strtolower(explode(':', $_SERVER['HTTP_HOST'] ?? '')[0]);
define('EN_DESARROLLO', in_array($host, $config['hosts_desarrollo'], true));

error_reporting(E_ALL);
ini_set('display_errors', EN_DESARROLLO ? '1' : '0');
ini_set('log_errors', '1');
date_default_timezone_set('America/Bogota');
mb_internal_encoding('UTF-8');

// Cargador PSR-4 del espacio de nombres App\ => app/
spl_autoload_register(static function (string $clase): void {
    if (strncmp($clase, 'App\\', 4) !== 0) {
        return;
    }
    $archivo = APP . '/' . str_replace('\\', '/', substr($clase, 4)) . '.php';
    if (is_file($archivo)) {
        require $archivo;
    }
});

require RAIZ . '/vendor/autoload.php';
require APP . '/Nucleo/ayudantes.php';

App\Nucleo\Config::cargar($config);
