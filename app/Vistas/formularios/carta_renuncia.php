<?php
/**
 * Formulario de la carta de renuncia.
 *
 * @var App\Modelos\CartaRenuncia $documento
 * @var array $seo
 */
use App\Modelos\Documento;
use App\Modelos\Genero;
use App\Nucleo\Formulario as F;
use App\Nucleo\Vista;

$d = $documento;
echo Vista::parcial('parciales/encabezado', [
    'seo' => $seo,
    'titulo' => 'Carta de renuncia voluntaria',
    'entrada' => 'Completa los datos y descarga una carta de renuncia formal y cordial, lista para firmar y entregar a tu empleador.',
]);
?>
<div class="contenedor diseno-formulario">
    <form class="formulario" method="post" action="<?= e(url('/carta-de-renuncia')) ?>#resumen-errores">
        <p class="formulario__nota">Los campos marcados con <span class="campo__req" aria-hidden="true">*</span><span class="visualmente-oculto">asterisco</span> son obligatorios.</p>
        <?= F::resumenErrores($d) ?>

        <section class="bloque" aria-labelledby="titulo-tus-datos">
            <h2 class="bloque__titulo" id="titulo-tus-datos"><?= icono('usuario') ?>Tus datos</h2>
            <p class="bloque__ayuda">Aparecen en la firma de la carta.</p>
            <div class="rejilla">
                <?= F::texto($d, 'nombre', 'Nombre completo', ['requerido' => true, 'ancho' => true, 'autocomplete' => 'name', 'placeholder' => 'Ej.: Sebastián Echavarría']) ?>
                <?= F::radios($d, 'genero', '¿Cómo quieres que se redacte la carta?', Genero::opciones(), ['requerido' => true, 'ayuda' => 'Ajusta palabras como «identificado» o «identificada» y «dispuesto» o «dispuesta».']) ?>
                <?= F::seleccion($d, 'tipo_documento', 'Tipo de documento', Documento::TIPOS_DOCUMENTO, ['requerido' => true]) ?>
                <?= F::texto($d, 'documento', 'Número de documento', ['requerido' => true, 'inputmode' => 'numeric', 'max' => 20, 'placeholder' => 'Ej.: 1111111111']) ?>
                <?= F::texto($d, 'telefono', 'Celular', ['tipo' => 'tel', 'inputmode' => 'tel', 'autocomplete' => 'tel', 'max' => 20, 'placeholder' => 'Ej.: 311 111 1111']) ?>
                <?= F::texto($d, 'cargo', 'Cargo que desempeñas', ['autocomplete' => 'organization-title', 'placeholder' => 'Ej.: Auxiliar administrativo']) ?>
            </div>
        </section>

        <section class="bloque" aria-labelledby="titulo-empresa">
            <h2 class="bloque__titulo" id="titulo-empresa"><?= icono('maletin') ?>Empresa y destinatario</h2>
            <p class="bloque__ayuda">Si conoces el nombre de tu jefe inmediato, la carta se dirige a esa persona.</p>
            <div class="rejilla">
                <?= F::texto($d, 'empresa', 'Nombre de la empresa', ['requerido' => true, 'ancho' => true, 'autocomplete' => 'organization', 'placeholder' => 'Ej.: <<NOMBRE_EMPRESA>>']) ?>
                <?= F::texto($d, 'nombre_jefe', 'Nombre del jefe inmediato', ['autocomplete' => 'off', 'placeholder' => 'Ej.: Bastián Echavarría']) ?>
                <?= F::radios($d, 'genero_jefe', 'El jefe inmediato es', Genero::opciones() + ['' => 'No indicar'], ['ayuda' => 'Para escribir «Estimado señor» o «Estimada señora».']) ?>
                <?= F::texto($d, 'fecha_renuncia', 'Último día de trabajo', ['tipo' => 'date', 'ayuda' => 'Opcional. Revisa si tu contrato exige un preaviso.']) ?>
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
        'imagen' => 'img/vistas/carta-de-renuncia.png',
        'alt' => 'Ejemplo de carta de renuncia generada con datos ficticios',
        'consejos' => [
            ['Mantén un tono cordial.', 'La carta queda en tu historia laboral y puede servirte para futuras referencias.'],
            ['Imprime dos copias.', 'Entrega una y pide que firmen la otra con la fecha de recibido.'],
            ['Revisa tu contrato.', 'Algunos contratos o reglamentos internos piden un aviso con anticipación.'],
            ['Firma a mano', 'sobre la línea antes de entregarla.'],
        ],
    ]) ?>
</div>
