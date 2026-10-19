<?php
/*
 * Configuración general del sitio.
 * url_publica se usa para la URL canónica, Open Graph y el sitemap: siempre apunta a producción
 * aunque el sitio se ejecute en local, para que los buscadores indexen solo una versión.
 */
return [
    'nombre' => 'GenDocs',
    'eslogan' => 'Documentos profesionales en PDF',
    'url_publica' => 'https://gendocs.infinityfreeapp.com',
    'idioma' => 'es-CO',
    'locale_og' => 'es_CO',
    'autor' => [
        'nombre' => 'Sebastián Echavarría',
        'alias' => 'sebasdev784',
        'sitio' => 'https://sebasdev784.com.co/',
        'github' => 'https://github.com/sebdevk784',
        'instagram' => 'https://www.instagram.com/sebasdev784/',
    ],
    // Hosts donde se muestran los errores de PHP; en cualquier otro (producción) se ocultan.
    'hosts_desarrollo' => ['localhost', '127.0.0.1', '::1'],
    // Preferencias de visualización guardadas en cookies (sin base de datos).
    'cookies' => [
        'tema' => 'gd_tema',
        'fuente' => 'gd_fuente',
        'duracion_dias' => 365,
    ],
    // Límites de los formularios.
    'limites' => [
        'texto' => 120,
        'texto_largo' => 900,
        'grupos' => 10,
        'foto_bytes' => 2 * 1024 * 1024,
    ],
];
