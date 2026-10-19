<?php
/**
 * Encabezado de las páginas internas: migas de pan, título y entrada.
 *
 * @var array $seo
 * @var string $titulo
 * @var string $entrada
 */
$migas = $seo['migas'] ?? [];
?>
<section class="banda encabezado" aria-labelledby="titulo-pagina">
    <div class="contenedor">
<?php if ($migas): ?>
        <nav class="migas" aria-label="Ruta de navegación">
            <ol>
<?php foreach ($migas as $i => [$texto, $destino]): ?>
<?php if ($i === count($migas) - 1): ?>
                <li aria-current="page"><?= e($texto) ?></li>
<?php else: ?>
                <li><a href="<?= e(url($destino)) ?>"><?= e($texto) ?></a></li>
<?php endif ?>
<?php endforeach ?>
            </ol>
        </nav>
<?php endif ?>
        <h1 id="titulo-pagina"><?= e($titulo) ?></h1>
        <p class="lead"><?= e($entrada) ?></p>
    </div>
</section>
