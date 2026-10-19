<?php
/**
 * Grupo repetible de la hoja de vida (formación, experiencia, referencias).
 * Sin JavaScript, «Agregar» y «Quitar» envían el formulario y el servidor devuelve un grupo más
 * o uno menos (#grupo-... regresa a esta sección). Con JavaScript, app.js lo hace en el navegador.
 *
 * @var App\Modelos\HojaVida $documento
 * @var string $grupo     clave de HojaVida::GRUPOS
 * @var string $titulo
 * @var string $icono
 * @var string $ayuda
 * @var string $singular  «Estudio», «Experiencia», «Referencia»
 * @var array  $campos    columna => [etiqueta, opciones: tipo, inputmode, placeholder, ancho, max, opciones, area]
 */
$filas = $documento->grupo($grupo);
$maximo = (int) config('limites.grupos');
$accion = url('/hoja-de-vida') . '#grupo-' . $grupo;
?>
<section class="bloque" id="grupo-<?= e($grupo) ?>" aria-labelledby="titulo-<?= e($grupo) ?>">
    <h2 class="bloque__titulo" id="titulo-<?= e($grupo) ?>"><?= icono($icono) ?><?= e($titulo) ?></h2>
    <p class="bloque__ayuda"><?= e($ayuda) ?></p>
    <div class="repetible" data-repetible data-maximo="<?= $maximo ?>">
<?php foreach ($filas as $i => $fila): ?>
        <div class="repetible__item" data-item>
            <div class="repetible__cabeza">
                <p class="repetible__numero"><?= e($singular) ?> <span data-numero><?= $i + 1 ?></span></p>
                <button class="btn btn--fantasma btn--peq repetible__quitar" type="submit" name="quitar" value="<?= e($grupo . ':' . $i) ?>"
                    formaction="<?= e($accion) ?>" formnovalidate data-quitar<?= count($filas) > 1 ? '' : ' hidden' ?>>
                    <?= icono('papelera') ?>Quitar<span class="visualmente-oculto"> <?= e(mb_strtolower($singular)) ?> <span data-numero><?= $i + 1 ?></span></span>
                </button>
            </div>
            <div class="rejilla">
<?php foreach ($campos as $columna => [$etiqueta, $o]): ?>
                <label class="campo<?= !empty($o['ancho']) ? ' campo--ancho' : '' ?>">
                    <span class="campo__etiqueta"><?= e($etiqueta) ?></span>
<?php if (isset($o['opciones'])): ?>
                    <select name="<?= e($grupo . '[' . $columna . '][]') ?>">
<?php foreach ($o['opciones'] as $valor => $texto): ?>
                        <option value="<?= e($valor) ?>"<?= $fila[$columna] === (string) $valor ? ' selected' : '' ?>><?= e($texto) ?></option>
<?php endforeach ?>
                    </select>
<?php elseif (!empty($o['area'])): ?>
                    <textarea name="<?= e($grupo . '[' . $columna . '][]') ?>" rows="4"
                        maxlength="<?= (int) config('limites.texto_largo') ?>"<?= isset($o['placeholder']) ? ' placeholder="' . e($o['placeholder']) . '"' : '' ?>><?= e($fila[$columna]) ?></textarea>
<?php else: ?>
                    <input type="<?= e($o['tipo'] ?? 'text') ?>" name="<?= e($grupo . '[' . $columna . '][]') ?>" value="<?= e($fila[$columna]) ?>"
                        maxlength="<?= (int) ($o['max'] ?? config('limites.texto')) ?>"<?= isset($o['inputmode']) ? ' inputmode="' . e($o['inputmode']) . '"' : '' ?><?= isset($o['placeholder']) ? ' placeholder="' . e($o['placeholder']) . '"' : '' ?>>
<?php endif ?>
                </label>
<?php endforeach ?>
            </div>
        </div>
<?php endforeach ?>
    </div>
    <button class="btn repetible__agregar" type="submit" name="agregar" value="<?= e($grupo) ?>" formaction="<?= e($accion) ?>" formnovalidate data-agregar<?= count($filas) >= $maximo ? ' hidden' : '' ?>>
        <?= icono('mas') ?>Agregar <?= e(mb_strtolower($singular)) ?>
    </button>
</section>
