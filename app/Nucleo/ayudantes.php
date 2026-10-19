<?php
/*
 * Funciones globales para las vistas.
 */
declare(strict_types=1);

use App\Nucleo\Config;
use App\Nucleo\Solicitud;

/** Escapa texto para HTML. Toda salida de datos del usuario pasa por aquí. */
function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** URL interna del sitio, respetando la carpeta donde esté instalado. */
function url(string $ruta = '/'): string
{
    return Solicitud::base() . $ruta;
}

/** URL de un archivo de assets/ con versión según su fecha de modificación (evita caché vieja). */
function recurso(string $ruta): string
{
    $archivo = RAIZ . '/assets/' . $ruta;
    $version = is_file($archivo) ? filemtime($archivo) : 0;
    return url('/assets/' . $ruta) . '?v=' . $version;
}

/** URL absoluta de producción (canónica, Open Graph, datos estructurados). */
function url_publica(string $ruta = '/'): string
{
    return rtrim((string) Config::obtener('url_publica'), '/') . $ruta;
}

function config(string $clave, $defecto = null)
{
    return Config::obtener($clave, $defecto);
}

/**
 * Versión instalada de un paquete de Composer tal como la registra vendor/composer
 * (por ejemplo «v3.1.6»), o '' si no se puede leer. Se lee en cada petición, así que
 * siempre coincide con la versión que realmente está en vendor/.
 */
function version_paquete(string $paquete): string
{
    try {
        return (string) \Composer\InstalledVersions::getPrettyVersion($paquete);
    } catch (\Throwable $error) {
        return '';
    }
}

/**
 * Icono SVG en línea (trazos de 24×24, decorativo: el texto del control da el nombre).
 * Trazos de Lucide (https://lucide.dev, licencia ISC; ver assets/licencias/lucide-LICENSE.txt),
 * atribuidos en el pie de página.
 */
function icono(string $nombre, string $clase = 'icono'): string
{
    static $trazos = [
        'documento' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/>',
        'sol' => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>',
        'luna' => '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>',
        'descarga' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>',
        'check' => '<path d="M20 6 9 17l-5-5"/>',
        'escudo' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
        'personas' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
        'maletin' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
        'texto' => '<path d="M4 7V4h16v3M9 20h6M12 4v16"/>',
        'celular' => '<rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/>',
        'regalo' => '<path d="M20 12v10H4V12M2 7h20v5H2zM12 22V7M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>',
        'mas' => '<path d="M12 5v14M5 12h14"/>',
        'papelera' => '<path d="M3 6h18M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6M10 11v6M14 11v6M9 6V4h6v2"/>',
        'flecha' => '<path d="M5 12h14M12 5l7 7-7 7"/>',
        'lapiz' => '<path d="M12 20h9M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"/>',
        'bombilla' => '<path d="M9 18h6M10 22h4M12 2a7 7 0 0 0-4 12.74V17h8v-2.26A7 7 0 0 0 12 2z"/>',
        'usuario' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'birrete' => '<path d="M22 10 12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
        'carta' => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/>',
        'github' => '<path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.4 5.4 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65S8.93 17.38 9 18v4"/><path d="M9 18c-4.51 2-5-2-7-2"/>',
        'info' => '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>',
        'globo' => '<circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
        'instagram' => '<rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37zM17.5 6.5h.01"/>',
    ];
    return '<svg class="' . e($clase) . '" viewBox="0 0 24 24" aria-hidden="true" focusable="false">' . ($trazos[$nombre] ?? '') . '</svg>';
}

/** Logotipo de GenDocs: hoja con esquina doblada sobre degradado índigo → violeta de la marca. */
function logotipo(string $clase = 'marca__logo'): string
{
    static $instancia = 0;
    $id = 'logo-degradado-' . (++$instancia);
    return '<svg class="' . e($clase) . '" viewBox="0 0 48 48" aria-hidden="true" focusable="false">'
        . '<defs><linearGradient id="' . $id . '" x1="0" y1="0" x2="1" y2="1">'
        . '<stop offset="0" stop-color="#482693"/><stop offset="1" stop-color="#6e00ff"/></linearGradient></defs>'
        . '<rect width="48" height="48" rx="12" fill="url(#' . $id . ')"/>'
        . '<path d="M16 11h11l7 7v17a2 2 0 0 1-2 2H16a2 2 0 0 1-2-2V13a2 2 0 0 1 2-2z" fill="#f5f7fa"/>'
        . '<path d="M27 11v6a1 1 0 0 0 1 1h6z" fill="#bfc7d5"/>'
        . '<path d="M18 24h12M18 28.5h12M18 33h7" stroke="#482693" stroke-width="2" stroke-linecap="round"/>'
        . '<circle cx="35" cy="36" r="3.2" fill="#00f0b5"/></svg>';
}
