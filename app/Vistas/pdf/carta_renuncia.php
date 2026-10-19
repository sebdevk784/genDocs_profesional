<?php
/**
 * Plantilla PDF de la carta de renuncia. Toda la redacción con género pasa por Genero::segun().
 *
 * @var App\Modelos\CartaRenuncia $documento
 */
use App\Modelos\Fecha;

$d = $documento;
$yo = $d->genero();
$jefe = $d->generoJefe();
$empresa = $d->valor('empresa');
$cargo = $d->valor('cargo');
$nombreJefe = $d->valor('nombre_jefe');
$ultimoDia = Fecha::larga($d->valor('fecha_renuncia'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carta de renuncia - <?= e($d->valor('nombre')) ?></title>
    <style><?= file_get_contents(__DIR__ . '/documento.css') ?></style>
</head>
<body>
    <div class="filete"></div>

    <p class="lugar-fecha"><?= e($d->valor('ciudad')) ?>, <?= e(Fecha::larga($d->valor('fecha'))) ?></p>

    <div class="destinatario">
<?php if ($nombreJefe !== ''): ?>
        <p><?= e($jefe->segun('Señor', 'Señora')) ?></p>
        <p><strong><?= e(mb_strtoupper($nombreJefe)) ?></strong></p>
        <p>Jefe inmediato</p>
        <p><?= e($empresa) ?></p>
<?php else: ?>
        <p>Señores</p>
        <p><strong><?= e(mb_strtoupper($empresa)) ?></strong></p>
<?php endif ?>
    </div>

    <p class="asunto"><strong>Asunto:</strong> renuncia voluntaria<?= $cargo !== '' ? ' al cargo de ' . e($cargo) : '' ?></p>

    <p class="saludo"><?= $nombreJefe !== '' && $jefe->especificado()
        ? e($jefe->segun('Estimado señor:', 'Estimada señora:'))
        : 'Cordial saludo:' ?></p>

    <p class="cuerpo">
        Por medio de la presente, yo, <?= e($d->valor('nombre')) ?>, <?= e($yo->segun('identificado', 'identificada')) ?>
        con <?= e($d->tipoDocumentoEnTexto()) ?> n.° <?= e($d->valor('documento')) ?>, presento formalmente mi renuncia
        voluntaria al cargo <?= $cargo !== '' ? 'de ' . e($cargo) . ' ' : '' ?>que desempeño en <?= e(rtrim($empresa, '.')) ?>.
<?php if ($ultimoDia !== ''): ?>
        Mi último día de trabajo será el <?= e($ultimoDia) ?>.
<?php endif ?>
    </p>
    <p class="cuerpo">
        Agradezco sinceramente las oportunidades de crecimiento personal y profesional que se me brindaron durante
        este tiempo; los aprendizajes adquiridos me permitieron consolidar mi perfil técnico y humano. Sin embargo,
        motivos personales me llevan a tomar esta decisión, que espero sea comprendida por la dirección de la empresa.
    </p>
    <p class="cuerpo">
        Quedo <?= e($yo->segun('dispuesto', 'dispuesta')) ?> a realizar la entrega de mis funciones y a colaborar en
        lo necesario para que la transición sea ordenada.
    </p>
    <p class="cuerpo">Sin otro particular, agradezco su atención y comprensión.</p>

    <p class="despedida">Atentamente,</p>

    <div class="firma">
        <div class="firma__linea"></div>
        <p><strong><?= e($d->valor('nombre')) ?></strong></p>
        <p><?= e($d->valor('tipo_documento')) ?>: <?= e($d->valor('documento')) ?></p>
<?php if ($d->valor('telefono') !== ''): ?>
        <p>Cel.: <?= e($d->valor('telefono')) ?></p>
<?php endif ?>
    </div>
</body>
</html>
