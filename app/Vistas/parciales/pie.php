<?php
/**
 * Pie de página con la banda de marca (cambia con el tema).
 */
$inicio = 2024;
$anio = (int) date('Y');
$versionDompdf = version_paquete('dompdf/dompdf');
?>
<footer class="pie banda">
    <div class="contenedor pie__rejilla">
        <div class="pie__marca">
            <a class="marca" href="<?= e(url('/')) ?>">
                <?= logotipo() ?>
                <span class="marca__texto">
                    <span class="marca__nombre">GenDocs</span>
                    <span class="marca__sub">Documentos profesionales</span>
                </span>
            </a>
            <p class="texto-suave">Hojas de vida y cartas laborales en PDF, gratis, accesibles y sin guardar tus datos.</p>
        </div>

        <nav aria-label="Documentos (pie de página)">
            <h2 class="pie__titulo">Documentos</h2>
            <ul class="pie__lista">
                <li><a href="<?= e(url('/hoja-de-vida')) ?>">Hoja de vida</a></li>
                <li><a href="<?= e(url('/carta-de-renuncia')) ?>">Carta de renuncia</a></li>
                <li><a href="<?= e(url('/carta-de-recomendacion')) ?>">Carta de recomendación personal</a></li>
            </ul>
        </nav>

        <div>
            <h2 class="pie__titulo">Contacto</h2>
            <ul class="pie__lista">
                <li><a href="<?= e(config('autor.sitio')) ?>" target="_blank" rel="noopener me"><?= icono('globo') ?>sebasdev784.com.co<span class="visualmente-oculto"> (sitio web personal, abre en una pestaña nueva)</span></a></li>
                <li><a href="<?= e(config('autor.instagram')) ?>" target="_blank" rel="noopener noreferrer me"><?= icono('instagram') ?>Instagram<span class="visualmente-oculto"> (abre en una pestaña nueva)</span></a></li>
                <li><a href="<?= e(config('autor.github')) ?>" target="_blank" rel="noopener noreferrer me"><?= icono('github') ?>GitHub<span class="visualmente-oculto"> (abre en una pestaña nueva)</span></a></li>
            </ul>
        </div>
    </div>

    <div class="contenedor pie__legal">
        <p>© <?= $inicio ?><?= $anio > $inicio ? '–' . $anio : '' ?> <?= e(config('autor.nombre')) ?>.
            Obra bajo licencia <a href="https://creativecommons.org/licenses/by-sa/4.0/deed.es" target="_blank" rel="noopener noreferrer license">CC BY-SA 4.0</a>.</p>
        <p class="pie__autor">
            <img src="<?= e(recurso('img/sebasdev784-96.webp')) ?>" alt="" width="28" height="28" loading="lazy" decoding="async">
            <span>Un proyecto de <a href="<?= e(config('autor.sitio')) ?>" target="_blank" rel="noopener"><strong><?= e(config('autor.alias')) ?></strong><span class="visualmente-oculto"> (abre en una pestaña nueva)</span></a></span>
        </p>
        <p class="pie__creditos">
            Créditos:
            iconos de <a href="https://lucide.dev" target="_blank" rel="noopener noreferrer">Lucide</a>
            (<a href="<?= e(url('/assets/licencias/lucide-LICENSE.txt')) ?>">licencia ISC</a>) ·
            tipografías Inter y Montserrat
            (<a href="<?= e(url('/assets/fonts/OFL-inter.txt')) ?>">OFL Inter</a>, <a href="<?= e(url('/assets/fonts/OFL-montserrat.txt')) ?>">OFL Montserrat</a>) ·
            PDF generados con <a href="https://github.com/dompdf/dompdf" target="_blank" rel="noopener noreferrer">dompdf</a><?php if ($versionDompdf !== ''): ?>
            <a href="https://github.com/dompdf/dompdf/releases/tag/<?= e($versionDompdf) ?>" target="_blank" rel="noopener noreferrer"><?= e(ltrim($versionDompdf, 'v')) ?></a><?php endif ?>
            (LGPL 2.1).
        </p>
    </div>
</footer>
