<?php
/**
 * Página de error (404 / 405).
 *
 * @var int $codigo
 * @var string $titulo
 * @var string $mensaje
 */
?>
<section class="banda error-pagina" aria-labelledby="titulo-error">
    <div class="contenedor">
        <p class="error-pagina__codigo resaltado" aria-hidden="true"><?= (int) $codigo ?></p>
        <h1 id="titulo-error"><?= e($titulo) ?></h1>
        <p class="lead"><?= e($mensaje) ?></p>
        <div class="error-pagina__enlaces">
            <a class="btn btn--primario" href="<?= e(url('/hoja-de-vida')) ?>">Hoja de vida</a>
            <a class="btn" href="<?= e(url('/carta-de-renuncia')) ?>">Carta de renuncia</a>
            <a class="btn" href="<?= e(url('/carta-de-recomendacion')) ?>">Carta de recomendación</a>
            <a class="btn" href="<?= e(url('/')) ?>">Ir al inicio</a>
        </div>
    </div>
</section>
