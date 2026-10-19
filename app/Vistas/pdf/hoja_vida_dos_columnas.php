<?php
/**
 * Plantilla PDF de la hoja de vida, diseño «Dos columnas» (basado en el formato .docx del
 * propietario, con los colores de la marca sebasdev784). Barra lateral: foto, contacto, datos personales y referencias. Columna
 * principal: nombre, perfil («Sobre mí»), experiencia, educación y proyectos.
 * Regla: ningún dato vacío se imprime y ninguna sección sin datos imprime su título.
 *
 * @var App\Modelos\HojaVida $documento
 */
use App\Modelos\Fecha;
use App\Modelos\HojaVida;

$d = $documento;
$foto = $d->foto();
$perfil = $d->perfil();
$contacto = array_values(array_filter(array_merge([
    $d->valor('celular'),
    $d->valor('correo'),
    $d->documentoCompleto(),
    implode(', ', array_filter([$d->valor('direccion'), $d->valor('barrio')])),
    $d->valor('ciudad'),
], $d->enlaces())));
$personalesDatos = array_filter([
    'Nacimiento' => Fecha::larga($d->valor('fecha_nacimiento')),
    'Estado civil' => $d->estadoCivil(),
]);
$experiencia = $d->grupoLleno('experiencia');
$formacion = $d->grupoLleno('formacion');
$proyectos = $d->grupoLleno('proyectos');
$referencias = [
    'Referencias personales' => $d->grupoLleno('referencias_personales'),
    'Referencias familiares' => $d->grupoLleno('referencias_familiares'),
];
$linea = static function (string $texto, string $clase = ''): string {
    return $texto === '' ? '' : '<p' . ($clase !== '' ? ' class="' . $clase . '"' : '') . '>' . nl2br(e($texto)) . '</p>';
};
/** Trazo de marca violeta, cian y menta bajo los títulos. */
$trazo = static function (string $variante): string {
    return '<table class="dc-trazo dc-trazo--' . $variante . '"><tr><td class="v">&nbsp;</td><td class="c">&nbsp;</td><td class="m">&nbsp;</td></tr></table>';
};
$primerTitulo = true;
$tituloLateral = static function (string $texto) use (&$primerTitulo, $foto, $trazo): string {
    $clase = $primerTitulo && !$foto ? ' class="dc-primero"' : '';
    $primerTitulo = false;
    return '<h2' . $clase . '>' . e($texto) . '</h2>' . $trazo('lateral');
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hoja de vida - <?= e($d->valor('nombre')) ?></title>
    <style><?= file_get_contents(__DIR__ . '/documento.css') ?>
        @page { margin: 1.5cm 1.6cm 1.5cm 0; }
    </style>
</head>
<body class="dc">
    <div class="dc-barra"></div>
    <div class="dc-filo"></div>

    <div class="dc-lateral">
<?php if ($foto): ?>
        <div class="dc-foto-caja"><img class="dc-foto" src="<?= e($foto) ?>" alt="Foto"></div>
<?php endif ?>
<?php if ($contacto): ?>
        <?= $tituloLateral('Contacto') ?>
<?php foreach ($contacto as $dato): ?>
        <p><?= e($dato) ?></p>
<?php endforeach ?>
<?php endif ?>
<?php if ($personalesDatos): ?>
        <?= $tituloLateral('Datos personales') ?>
<?php foreach ($personalesDatos as $etiqueta => $valor): ?>
        <p><?= e($etiqueta) ?>: <?= e($valor) ?></p>
<?php endforeach ?>
<?php endif ?>
<?php foreach ($referencias as $titulo => $filas): ?>
<?php if ($filas): ?>
        <?= $tituloLateral($titulo) ?>
<?php foreach ($filas as $r): ?>
        <div class="dc-ref">
            <?= $linea($r['nombre'], 'dc-ref__nombre') ?>
            <?= $linea(implode(' · ', array_filter([$r['parentesco'] ?? '', $r['ocupacion']])), 'dc-ref__dato') ?>
            <?= $linea($r['celular'], 'dc-ref__dato') ?>
        </div>
<?php endforeach ?>
<?php endif ?>
<?php endforeach ?>
    </div>

    <div class="dc-principal">
        <h1 class="dc-nombre"><?= e($d->valor('nombre')) ?></h1>
        <?= $linea($d->valor('profesion'), 'dc-profesion') ?>
        <?= $trazo('ancho') ?>

<?php if ($perfil !== ''): ?>
        <h2>Sobre mí</h2>
        <?= $trazo('corto') ?>
        <p class="dc-texto"><?= nl2br(e($perfil)) ?></p>
<?php endif ?>

<?php if ($experiencia): ?>
        <h2>Experiencia</h2>
        <?= $trazo('corto') ?>
<?php foreach ($experiencia as $x): ?>
<?php
    $tiempo = HojaVida::duracion($x['duracion'], $x['unidad']);
    $encabezado = $x['empresa'] !== '' ? e($x['empresa']) . ($tiempo !== '' ? ' <span>(' . e($tiempo) . ')</span>' : '') : '';
    $detalle = implode(' · ', array_filter([
        $x['jefe'] !== '' ? 'Jefe inmediato: ' . $x['jefe'] : '',
        $x['telefono'] !== '' ? 'Tel.: ' . $x['telefono'] : '',
    ]));
?>
        <div class="dc-item">
<?php if ($encabezado !== ''): ?>
            <p class="dc-item__titulo"><?= $encabezado ?></p>
<?php endif ?>
            <?= $linea($x['cargo'] !== '' ? $x['cargo'] . ($encabezado === '' && $tiempo !== '' ? ' (' . $tiempo . ')' : '') : '', 'dc-cargo') ?>
            <?= $linea($x['descripcion']) ?>
            <?= $linea($detalle, 'dc-detalle') ?>
        </div>
<?php endforeach ?>
<?php endif ?>

<?php if ($formacion): ?>
        <h2>Educación</h2>
        <?= $trazo('corto') ?>
<?php foreach ($formacion as $f): ?>
        <div class="dc-item">
            <?= $linea($f['institucion'], 'dc-institucion') ?>
            <?= $linea($f['titulo'] !== '' ? $f['titulo'] . ($f['anio'] !== '' ? ' (' . $f['anio'] . ')' : '') : $f['anio']) ?>
        </div>
<?php endforeach ?>
<?php endif ?>

<?php if ($proyectos): ?>
        <h2>Proyectos</h2>
        <?= $trazo('corto') ?>
<?php foreach ($proyectos as $p): ?>
        <div class="dc-item">
<?php if ($p['nombre'] !== '' && $p['descripcion'] !== ''): ?>
            <p><span class="dc-proyecto"><?= e($p['nombre']) ?>,</span> <?= nl2br(e($p['descripcion'])) ?></p>
<?php else: ?>
            <?= $linea($p['nombre'], 'dc-proyecto') ?>
            <?= $linea($p['descripcion']) ?>
<?php endif ?>
        </div>
<?php endforeach ?>
<?php endif ?>

        <div class="cv-firma firma">
            <div class="firma__linea"></div>
            <p><strong><?= e($d->valor('nombre')) ?></strong></p>
            <?= $linea($d->documentoCompleto()) ?>
        </div>
    </div>
</body>
</html>
