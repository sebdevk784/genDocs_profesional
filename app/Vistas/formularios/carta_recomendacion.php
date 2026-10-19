<?php
/**
 * Formulario de la carta de recomendación personal.
 *
 * @var App\Modelos\CartaRecomendacion $documento
 * @var array $seo
 */
use App\Modelos\CartaRecomendacion;
use App\Modelos\Documento;
use App\Modelos\Genero;
use App\Nucleo\Formulario as F;
use App\Nucleo\Vista;

$d = $documento;
echo Vista::parcial('parciales/encabezado', [
    'seo' => $seo,
    'titulo' => 'Carta de recomendación personal',
    'entrada' => 'Genera una carta de recomendación lista para que la firme alguien que te conoce y adjuntarla a tu hoja de vida.',
]);
?>
<div class="contenedor diseno-formulario">
    <form class="formulario" method="post" action="<?= e(url('/carta-de-recomendacion')) ?>#resumen-errores">
        <p class="formulario__nota">Los campos marcados con <span class="campo__req" aria-hidden="true">*</span><span class="visualmente-oculto">asterisco</span> son obligatorios.</p>
        <?= F::resumenErrores($d) ?>

        <section class="bloque" aria-labelledby="titulo-recomendado">
            <h2 class="bloque__titulo" id="titulo-recomendado"><?= icono('usuario') ?>Persona recomendada</h2>
            <p class="bloque__ayuda">Normalmente eres tú: la persona que presentará la carta.</p>
            <div class="rejilla">
                <?= F::texto($d, 'nombre_recomendado', 'Nombre completo', ['requerido' => true, 'ancho' => true, 'autocomplete' => 'name', 'placeholder' => 'Ej.: Sebastián Echavarría']) ?>
                <?= F::radios($d, 'genero_recomendado', 'La persona recomendada es', Genero::opciones(), ['requerido' => true, 'ayuda' => 'Ajusta palabras como «conocerlo» o «conocerla» y «recomendarlo» o «recomendarla».']) ?>
                <?= F::seleccion($d, 'tipo_documento_recomendado', 'Tipo de documento', Documento::TIPOS_DOCUMENTO, ['requerido' => true]) ?>
                <?= F::texto($d, 'documento_recomendado', 'Número de documento', ['requerido' => true, 'inputmode' => 'numeric', 'max' => 20, 'placeholder' => 'Ej.: 1111111111']) ?>
                <?= F::texto($d, 'tiempo', 'Tiempo de conocerse', ['requerido' => true, 'inputmode' => 'numeric', 'max' => 2, 'placeholder' => 'Ej.: 5']) ?>
                <?= F::seleccion($d, 'unidad_tiempo', 'Unidad de tiempo', CartaRecomendacion::UNIDADES_TIEMPO, ['requerido' => true]) ?>
            </div>
        </section>

        <section class="bloque" aria-labelledby="titulo-recomendador">
            <h2 class="bloque__titulo" id="titulo-recomendador"><?= icono('personas') ?>Quien recomienda</h2>
            <p class="bloque__ayuda">La persona que firma la carta. Sus datos permiten que la empresa la contacte.</p>
            <div class="rejilla">
                <?= F::texto($d, 'nombre', 'Nombre completo', ['requerido' => true, 'ancho' => true, 'autocomplete' => 'off', 'placeholder' => 'Ej.: Sebastiana Echavarría']) ?>
                <?= F::radios($d, 'genero', 'Quien recomienda es', Genero::opciones(), ['requerido' => true, 'ayuda' => 'Ajusta «identificado» o «identificada» en el texto de la carta.']) ?>
                <?= F::seleccion($d, 'tipo_documento', 'Tipo de documento', Documento::TIPOS_DOCUMENTO, ['requerido' => true]) ?>
                <?= F::texto($d, 'documento', 'Número de documento', ['requerido' => true, 'inputmode' => 'numeric', 'max' => 20, 'placeholder' => 'Ej.: 11111111']) ?>
                <?= F::texto($d, 'telefono', 'Teléfono de contacto', ['requerido' => true, 'tipo' => 'tel', 'inputmode' => 'tel', 'max' => 20, 'placeholder' => 'Ej.: 311 111 1111']) ?>
            </div>
        </section>

        <section class="bloque" aria-labelledby="titulo-carta">
            <h2 class="bloque__titulo" id="titulo-carta"><?= icono('carta') ?>Lugar y fecha</h2>
            <div class="rejilla">
                <?= F::texto($d, 'ciudad', 'Ciudad', ['requerido' => true, 'autocomplete' => 'address-level2', 'max' => 80, 'placeholder' => 'Ej.: Rionegro, Antioquia']) ?>
                <?= F::texto($d, 'fecha', 'Fecha de la carta', ['tipo' => 'date', 'requerido' => true]) ?>
            </div>
        </section>

        <?= Vista::parcial('parciales/enviar', ['texto' => 'Descargar carta en PDF']) ?>
    </form>

    <?= Vista::parcial('parciales/lateral', [
        'imagen' => 'img/vistas/carta-de-recomendacion.png',
        'alt' => 'Ejemplo de carta de recomendación personal generada con datos ficticios',
        'consejos' => [
            ['Elige bien a quien recomienda:', 'una persona que te conozca y que no sea de tu familia.'],
            ['Avísale antes.', 'La empresa puede llamarla para confirmar la recomendación.'],
            ['Pide dos cartas', 'si la vacante lo solicita: genera una por cada persona.'],
            ['Firma a mano', 'sobre la línea antes de entregarla.'],
        ],
    ]) ?>
</div>
