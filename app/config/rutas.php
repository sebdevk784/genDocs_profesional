<?php
/*
 * Tabla de rutas: método + ruta => [controlador, acción].
 * Las rutas antiguas (archivos .php del sitio anterior) se redirigen con 301 para no perder
 * el posicionamiento ni los enlaces existentes.
 */
use App\Controladores\CartaRecomendacionControlador;
use App\Controladores\CartaRenunciaControlador;
use App\Controladores\HojaVidaControlador;
use App\Controladores\InicioControlador;
use App\Controladores\PreferenciasControlador;

return [
    'rutas' => [
        'GET /' => [InicioControlador::class, 'index'],
        'GET /hoja-de-vida' => [HojaVidaControlador::class, 'formulario'],
        'POST /hoja-de-vida' => [HojaVidaControlador::class, 'generar'],
        'GET /carta-de-renuncia' => [CartaRenunciaControlador::class, 'formulario'],
        'POST /carta-de-renuncia' => [CartaRenunciaControlador::class, 'generar'],
        'GET /carta-de-recomendacion' => [CartaRecomendacionControlador::class, 'formulario'],
        'POST /carta-de-recomendacion' => [CartaRecomendacionControlador::class, 'generar'],
        'POST /preferencias' => [PreferenciasControlador::class, 'guardar'],
    ],
    'redirecciones' => [
        '/index.php' => '/',
        '/hoja_vida.php' => '/hoja-de-vida',
        '/carta_renuncia.php' => '/carta-de-renuncia',
        '/carta_recomendacion_personal.php' => '/carta-de-recomendacion',
    ],
];
