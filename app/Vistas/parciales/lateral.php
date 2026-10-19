<?php
/**
 * Columna lateral de los formularios: vista previa y consejos.
 *
 * @var string $imagen
 * @var string $alt
 * @var array $consejos  [titulo en negrita, texto]
 */
?>
<aside class="lateral" aria-label="Ayuda">
    <div class="tarjeta">
        <h2><?= icono('documento') ?>Así se verá</h2>
        <img class="lateral__vista" src="<?= e(recurso($imagen)) ?>" alt="<?= e($alt) ?>" width="816" height="1056" loading="lazy" decoding="async">
    </div>
    <div class="tarjeta">
        <h2><?= icono('bombilla') ?>Consejos</h2>
        <ul class="consejos">
<?php foreach ($consejos as [$titulo, $texto]): ?>
            <li><strong><?= e($titulo) ?></strong> <?= e($texto) ?></li>
<?php endforeach ?>
        </ul>
    </div>
</aside>
