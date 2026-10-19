<?php
/**
 * Plantilla general del sitio: metadatos SEO, Open Graph, datos estructurados, cabecera y pie.
 *
 * @var string $contenido
 * @var array $seo  titulo, descripcion, ruta (null = sin canónica), indexar, migas, datos_estructurados
 * @var App\Nucleo\Preferencias $preferencias
 */
use App\Nucleo\Vista;

$titulo = $seo['titulo'] ?? config('nombre');
$descripcion = $seo['descripcion'] ?? '';
$canonica = isset($seo['ruta']) ? url_publica($seo['ruta']) : null;
$indexar = $seo['indexar'] ?? true;
$imagenSocial = url_publica('/assets/img/og-gendocs.jpg');
$tema = $preferencias->temaHtml();

$datosEstructurados = [[
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => config('nombre'),
    'alternateName' => 'GenDocs Profesional',
    'url' => url_publica('/'),
    'inLanguage' => config('idioma'),
    'publisher' => ['@type' => 'Person', 'name' => config('autor.nombre'), 'url' => config('autor.sitio')],
]];
if (!empty($seo['migas'])) {
    $datosEstructurados[] = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => array_map(static function (array $miga, int $i): array {
            return ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $miga[0], 'item' => url_publica($miga[1])];
        }, $seo['migas'], array_keys($seo['migas'])),
    ];
}
$datosEstructurados = array_merge($datosEstructurados, $seo['datos_estructurados'] ?? []);
$json = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP;
?>
<!DOCTYPE html>
<html lang="<?= e(config('idioma')) ?>" data-fuente="<?= $preferencias->fuente() ?>"<?= $tema ? ' data-theme="' . e($tema) . '"' : '' ?> data-base="<?= e(url('/')) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo) ?></title>
<?php if ($descripcion !== ''): ?>
    <meta name="description" content="<?= e($descripcion) ?>">
<?php endif ?>
    <meta name="robots" content="<?= $indexar ? 'index, follow, max-image-preview:large, max-snippet:-1' : 'noindex, follow' ?>">
<?php if ($canonica): ?>
    <link rel="canonical" href="<?= e($canonica) ?>">
<?php endif ?>
    <meta name="author" content="<?= e(config('autor.nombre')) ?>">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#f5f7fa" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#040336" media="(prefers-color-scheme: dark)">
    <meta name="format-detection" content="telephone=no">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= e(config('nombre')) ?>">
    <meta property="og:locale" content="<?= e(config('locale_og')) ?>">
    <meta property="og:title" content="<?= e($titulo) ?>">
<?php if ($descripcion !== ''): ?>
    <meta property="og:description" content="<?= e($descripcion) ?>">
<?php endif ?>
<?php if ($canonica): ?>
    <meta property="og:url" content="<?= e($canonica) ?>">
<?php endif ?>
    <meta property="og:image" content="<?= e($imagenSocial) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="GenDocs: hoja de vida y cartas laborales en PDF gratis">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($titulo) ?>">
<?php if ($descripcion !== ''): ?>
    <meta name="twitter:description" content="<?= e($descripcion) ?>">
<?php endif ?>
    <meta name="twitter:image" content="<?= e($imagenSocial) ?>">

    <link rel="icon" href="<?= e(url('/favicon.ico')) ?>" sizes="32x32">
    <link rel="icon" href="<?= e(recurso('img/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?= e(recurso('img/apple-touch-icon.png')) ?>">
    <link rel="preload" href="<?= e(url('/assets/fonts/montserrat-latin-wght-normal.woff2')) ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= e(url('/assets/fonts/inter-latin-wght-normal.woff2')) ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= e(recurso('css/marca.css')) ?>">
    <link rel="stylesheet" href="<?= e(recurso('css/app.css')) ?>">
    <script src="<?= e(recurso('js/app.js')) ?>" defer></script>
<?php foreach ($datosEstructurados as $dato): ?>
    <script type="application/ld+json"><?= json_encode($dato, $json) ?></script>
<?php endforeach ?>
</head>
<body>
    <a class="salto" href="#contenido">Saltar al contenido principal</a>
    <?= Vista::parcial('parciales/cabecera') ?>
    <main id="contenido" tabindex="-1">
<?= $contenido ?>
    </main>
    <?= Vista::parcial('parciales/pie') ?>
</body>
</html>
