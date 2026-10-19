<?php
/**
 * Cabecera: marca, navegación y preferencias de visualización.
 * Los botones de preferencias son un formulario normal (funcionan sin JavaScript);
 * app.js los mejora para aplicar el cambio al instante sin recargar.
 *
 * @var App\Nucleo\Solicitud $solicitud
 * @var App\Nucleo\Preferencias $preferencias
 */
use App\Nucleo\Preferencias;

$ruta = $solicitud->ruta();
$enlaces = [
    '/hoja-de-vida' => 'Hoja de vida',
    '/carta-de-renuncia' => 'Carta de renuncia',
    '/carta-de-recomendacion' => 'Carta de recomendación',
];
?>
<header class="cabecera">
    <div class="contenedor cabecera__fila">
        <a class="marca" href="<?= e(url('/')) ?>"<?= $ruta === '/' ? ' aria-current="page"' : '' ?>>
            <?= logotipo() ?>
            <span class="marca__texto">
                <span class="marca__nombre">GenDocs</span>
                <span class="marca__sub">Documentos profesionales</span>
            </span>
        </a>

        <nav class="nav" aria-label="Documentos">
            <ul class="nav__lista">
<?php foreach ($enlaces as $destino => $texto): ?>
                <li><a class="nav__enlace" href="<?= e(url($destino)) ?>"<?= $ruta === $destino ? ' aria-current="page"' : '' ?>><?= e($texto) ?></a></li>
<?php endforeach ?>
            </ul>
        </nav>

        <form class="ajustes" method="post" action="<?= e(url('/preferencias')) ?>" data-preferencias
            data-cookie-tema="<?= e(config('cookies.tema')) ?>" data-cookie-fuente="<?= e(config('cookies.fuente')) ?>"
            data-dias="<?= (int) config('cookies.duracion_dias') ?>"
            data-fuente-min="<?= Preferencias::FUENTE_MINIMA ?>" data-fuente-normal="<?= Preferencias::FUENTE_NORMAL ?>" data-fuente-max="<?= Preferencias::FUENTE_MAXIMA ?>">
            <input type="hidden" name="volver" value="<?= e($ruta) ?>">
            <div class="ajustes__grupo" role="group" aria-label="Tamaño de letra">
                <button class="ajuste ajuste--menor" type="submit" name="fuente" value="menos" title="Reducir tamaño de letra"<?= $preferencias->puedeReducir() ? '' : ' disabled' ?>>
                    <span aria-hidden="true">A−</span><span class="visualmente-oculto">Reducir tamaño de letra</span>
                </button>
                <button class="ajuste" type="submit" name="fuente" value="normal" title="Tamaño de letra normal">
                    <span aria-hidden="true">A</span><span class="visualmente-oculto">Tamaño de letra normal</span>
                </button>
                <button class="ajuste ajuste--mayor" type="submit" name="fuente" value="mas" title="Aumentar tamaño de letra"<?= $preferencias->puedeAumentar() ? '' : ' disabled' ?>>
                    <span aria-hidden="true">A+</span><span class="visualmente-oculto">Aumentar tamaño de letra</span>
                </button>
            </div>
            <button class="ajuste ajuste--tema tema-oscuro" type="submit" name="tema" value="oscuro" title="Activar modo oscuro">
                <?= icono('luna') ?><span class="visualmente-oculto">Activar modo oscuro</span>
            </button>
            <button class="ajuste ajuste--tema tema-claro" type="submit" name="tema" value="claro" title="Activar modo claro">
                <?= icono('sol') ?><span class="visualmente-oculto">Activar modo claro</span>
            </button>
            <p class="visualmente-oculto" role="status" data-anuncio></p>
        </form>
    </div>
</header>
