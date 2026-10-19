<?php
/**
 * Botón de descarga y aviso de privacidad al final de cada formulario.
 *
 * @var string $texto
 */
?>
<div class="formulario__acciones">
    <button class="btn btn--primario btn--grande" type="submit"><?= icono('descarga') ?><?= e($texto) ?></button>
    <p><?= icono('escudo') ?><span>Tus datos se usan solo para crear el PDF y no se guardan en ningún lugar.</span></p>
</div>
