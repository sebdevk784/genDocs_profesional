<?php
/**
 * Plantilla PDF de la carta de recomendación personal.
 * Dos géneros: el de quien recomienda ($yo) y el de la persona recomendada ($el).
 *
 * @var App\Modelos\CartaRecomendacion $documento
 */
use App\Modelos\Fecha;

$d = $documento;
$yo = $d->genero();
$el = $d->generoRecomendado();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carta de recomendación - <?= e($d->valor('nombre_recomendado')) ?></title>
    <style><?= file_get_contents(__DIR__ . '/documento.css') ?></style>
</head>
<body>
    <div class="filete"></div>

    <p class="lugar-fecha"><?= e($d->valor('ciudad')) ?>, <?= e(Fecha::larga($d->valor('fecha'))) ?></p>

    <div class="destinatario">
        <p><strong>A QUIEN PUEDA INTERESAR</strong></p>
    </div>

    <p class="asunto"><strong>Asunto:</strong> recomendación personal de <?= e($d->valor('nombre_recomendado')) ?></p>

    <p class="saludo">Reciba un cordial saludo.</p>

    <p class="cuerpo">
        Yo, <?= e($d->valor('nombre')) ?>, <?= e($yo->segun('identificado', 'identificada')) ?> con
        <?= e($d->tipoDocumentoEnTexto()) ?> n.° <?= e($d->valor('documento')) ?>, me permito recomendar a
        <?= e($d->valor('nombre_recomendado')) ?>, <?= e($el->segun('identificado', 'identificada')) ?> con
        <?= e($d->tipoDocumentoEnTexto('tipo_documento_recomendado')) ?> n.° <?= e($d->valor('documento_recomendado')) ?>.
        He tenido el gusto de <?= e($el->segun('conocerlo', 'conocerla')) ?> durante <?= e($d->tiempoConocidos()) ?>
        y puedo afirmar que es una persona íntegra, responsable y trabajadora.
    </p>
    <p class="cuerpo">
        Destaco su honestidad y su capacidad para asumir con compromiso las responsabilidades que se le encomienden.
        Puedo asegurar que es <?= e($el->segun('un hombre competente, eficaz y respetuoso', 'una mujer competente, eficaz y respetuosa')) ?>
        con los demás, cualidades que <?= e($el->segun('lo', 'la')) ?> hacen <?= e($el->segun('digno', 'digna')) ?> de confianza.
    </p>
    <p class="cuerpo">
        Por estos motivos, <?= e($el->segun('lo', 'la')) ?> recomiendo ampliamente para cualquier labor o cargo que
        usted considere conveniente.
    </p>
    <p class="cuerpo">
        Para ampliar esta información, puede contactarme al teléfono <?= e($d->valor('telefono')) ?>.
    </p>

    <p class="despedida">Atentamente,</p>

    <div class="firma">
        <div class="firma__linea"></div>
        <p><strong><?= e($d->valor('nombre')) ?></strong></p>
        <p><?= e($d->valor('tipo_documento')) ?>: <?= e($d->valor('documento')) ?></p>
        <p>Tel.: <?= e($d->valor('telefono')) ?></p>
    </div>
</body>
</html>
