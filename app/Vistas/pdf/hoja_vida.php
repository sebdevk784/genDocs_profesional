<?php
/**
 * Plantilla PDF de la hoja de vida, diseño «Clásica» (una columna).
 * Regla: ningún dato vacío se imprime y ninguna sección sin datos imprime su título.
 *
 * @var App\Modelos\HojaVida $documento
 */
use App\Modelos\Fecha;
use App\Modelos\HojaVida;

$d = $documento;
$foto = $d->foto();
$perfil = $d->perfil();
$contacto = array_merge(array_filter([$d->valor('celular'), $d->valor('correo'), $d->valor('ciudad')]), $d->enlaces());
$datos = array_filter([
    'Documento' => $d->documentoCompleto(),
    'Fecha de nacimiento' => Fecha::larga($d->valor('fecha_nacimiento')),
    'Estado civil' => $d->estadoCivil(),
    'Dirección' => implode(', ', array_filter([$d->valor('direccion'), $d->valor('barrio'), $d->valor('ciudad')])),
]);
$formacion = $d->grupoLleno('formacion');
$experiencia = $d->grupoLleno('experiencia');
$proyectos = $d->grupoLleno('proyectos');
$familiares = $d->grupoLleno('referencias_familiares');
$personales = $d->grupoLleno('referencias_personales');

/** Une las partes no vacías con un separador. */
$unir = static function (array $partes, string $separador = ' · '): string {
    return implode($separador, array_filter($partes, static function ($p): bool {
        return $p !== '' && $p !== null;
    }));
};
/** Imprime un párrafo solo si tiene texto. */
$linea = static function (string $texto, string $clase = ''): string {
    return $texto === '' ? '' : '<p' . ($clase !== '' ? ' class="' . $clase . '"' : '') . '>' . nl2br(e($texto)) . '</p>';
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hoja de vida - <?= e($d->valor('nombre')) ?></title>
    <style><?= file_get_contents(__DIR__ . '/documento.css') ?></style>
</head>
<body>
    <table class="cv-cabecera">
        <tr>
            <td>
                <p class="cv-titulo-doc">Hoja de vida</p>
                <h1 class="cv-nombre"><?= e($d->valor('nombre')) ?></h1>
                <?= $linea($d->valor('profesion'), 'cv-profesion') ?>
                <?= $linea(implode('  ·  ', $contacto), 'cv-contacto') ?>
            </td>
<?php if ($foto): ?>
            <td class="cv-cabecera__foto"><img class="cv-foto" src="<?= e($foto) ?>" alt="Foto"></td>
<?php endif ?>
        </tr>
    </table>

<?php if ($perfil !== ''): ?>
    <div class="cv-seccion">
        <h2>Perfil profesional</h2>
        <p class="cv-perfil"><?= nl2br(e($perfil)) ?></p>
    </div>
<?php endif ?>

<?php if ($datos): ?>
    <div class="cv-seccion">
        <h2>Datos personales</h2>
        <table class="cv-datos">
<?php foreach ($datos as $etiqueta => $valor): ?>
            <tr><td class="etiqueta"><?= e($etiqueta) ?></td><td><?= e($valor) ?></td></tr>
<?php endforeach ?>
        </table>
    </div>
<?php endif ?>

<?php if ($formacion): ?>
    <div class="cv-seccion">
        <h2>Formación académica</h2>
<?php foreach ($formacion as $f): ?>
        <div class="cv-item">
            <?= $linea($f['titulo'] !== '' ? $f['titulo'] : $f['institucion'], 'cv-item__titulo') ?>
            <?= $linea($unir([$f['titulo'] !== '' ? $f['institucion'] : '', $f['anio']]), 'cv-item__detalle') ?>
        </div>
<?php endforeach ?>
    </div>
<?php endif ?>

<?php if ($experiencia): ?>
    <div class="cv-seccion">
        <h2>Experiencia laboral</h2>
<?php foreach ($experiencia as $x): ?>
<?php $tiempo = HojaVida::duracion($x['duracion'], $x['unidad']); ?>
        <div class="cv-item">
            <?= $linea($x['empresa'] !== '' ? $x['empresa'] : $x['cargo'], 'cv-item__titulo') ?>
            <?= $linea($unir([$x['empresa'] !== '' ? $x['cargo'] : '', $tiempo !== '' ? 'Tiempo laborado: ' . $tiempo : ''])) ?>
            <?= $linea($x['descripcion'], 'cv-item__texto') ?>
            <?= $linea($unir([
                $x['jefe'] !== '' ? 'Jefe inmediato: ' . $x['jefe'] : '',
                $x['telefono'] !== '' ? 'Tel.: ' . $x['telefono'] : '',
            ]), 'cv-item__detalle') ?>
        </div>
<?php endforeach ?>
    </div>
<?php endif ?>

<?php if ($proyectos): ?>
    <div class="cv-seccion">
        <h2>Proyectos</h2>
<?php foreach ($proyectos as $p): ?>
        <div class="cv-item">
            <?= $linea($p['nombre'], 'cv-item__titulo') ?>
            <?= $linea($p['descripcion'], 'cv-item__texto') ?>
        </div>
<?php endforeach ?>
    </div>
<?php endif ?>

<?php if ($familiares): ?>
    <div class="cv-seccion">
        <h2>Referencias familiares</h2>
<?php foreach ($familiares as $r): ?>
        <div class="cv-item">
            <?= $linea($r['nombre'], 'cv-item__titulo') ?>
            <?= $linea($unir([$r['parentesco'], $r['ocupacion'], $r['celular'] !== '' ? 'Cel.: ' . $r['celular'] : '']), 'cv-item__detalle') ?>
        </div>
<?php endforeach ?>
    </div>
<?php endif ?>

<?php if ($personales): ?>
    <div class="cv-seccion">
        <h2>Referencias personales</h2>
<?php foreach ($personales as $r): ?>
        <div class="cv-item">
            <?= $linea($r['nombre'], 'cv-item__titulo') ?>
            <?= $linea($unir([$r['ocupacion'], $r['celular'] !== '' ? 'Cel.: ' . $r['celular'] : '']), 'cv-item__detalle') ?>
        </div>
<?php endforeach ?>
    </div>
<?php endif ?>

    <div class="cv-firma firma">
        <div class="firma__linea"></div>
        <p><strong><?= e($d->valor('nombre')) ?></strong></p>
        <?= $linea($d->documentoCompleto()) ?>
    </div>
</body>
</html>
