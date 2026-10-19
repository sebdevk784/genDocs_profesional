<?php
/**
 * Aviso informativo reutilizable (icono «info» de Lucide + texto). No es un error: orienta al
 * usuario antes de que algo falle. role="note" para que los lectores de pantalla lo identifiquen.
 *
 * @var string $texto
 * @var string|null $titulo
 * @var string|null $id      para enlazarlo con aria-describedby desde un campo
 */
?>
<div class="aviso campo--ancho" role="note"<?= !empty($id) ? ' id="' . e($id) . '"' : '' ?>>
    <?= icono('info', 'icono aviso__icono') ?>
    <p><?php if (!empty($titulo)): ?><strong><?= e($titulo) ?></strong> <?php endif ?><?= e($texto) ?></p>
</div>
