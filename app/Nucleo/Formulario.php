<?php
declare(strict_types=1);

namespace App\Nucleo;

use App\Modelos\Documento;

/**
 * Ayudante de vistas para campos de formulario accesibles: etiqueta asociada, texto de ayuda,
 * mensaje de error enlazado con aria-describedby y aria-invalid, y el valor ya escrito.
 */
final class Formulario
{
    /** Opciones: tipo, requerido, ayuda, placeholder, autocomplete, inputmode, max, ancho, min, maximo. */
    public static function texto(Documento $doc, string $nombre, string $etiqueta, array $o = []): string
    {
        $tipo = $o['tipo'] ?? 'text';
        $atributos = [
            'type' => $tipo,
            'name' => $nombre,
            'value' => $tipo === 'file' ? null : $doc->valor($nombre),
            'placeholder' => $o['placeholder'] ?? null,
            'autocomplete' => $o['autocomplete'] ?? null,
            'inputmode' => $o['inputmode'] ?? null,
            'maxlength' => in_array($tipo, ['date', 'file'], true) ? null : ($o['max'] ?? Config::obtener('limites.texto')),
            'min' => $o['min'] ?? null,
            'max' => $o['maximo'] ?? null,
            'accept' => $o['accept'] ?? null,
        ];
        $control = '<input' . self::atributos($nombre, $doc, $o) . self::lista($atributos) . '>';
        return self::envolver($doc, $nombre, $etiqueta, $control, $o);
    }

    public static function area(Documento $doc, string $nombre, string $etiqueta, array $o = []): string
    {
        $atributos = [
            'name' => $nombre,
            'rows' => $o['filas'] ?? 5,
            'maxlength' => $o['max'] ?? Config::obtener('limites.texto_largo'),
            'placeholder' => $o['placeholder'] ?? null,
        ];
        $control = '<textarea' . self::atributos($nombre, $doc, $o) . self::lista($atributos) . '>'
            . e($doc->valor($nombre)) . '</textarea>';
        return self::envolver($doc, $nombre, $etiqueta, $control, ['ancho' => true] + $o);
    }

    public static function seleccion(Documento $doc, string $nombre, string $etiqueta, array $opciones, array $o = []): string
    {
        $actual = $doc->valor($nombre);
        $html = '<select' . self::atributos($nombre, $doc, $o) . self::lista(['name' => $nombre]) . '>';
        if (isset($o['vacia'])) {
            $html .= '<option value="">' . e($o['vacia']) . '</option>';
        }
        foreach ($opciones as $valor => $texto) {
            $html .= '<option value="' . e($valor) . '"' . ((string) $valor === $actual ? ' selected' : '') . '>'
                . e($texto) . '</option>';
        }
        $html .= '</select>';
        return self::envolver($doc, $nombre, $etiqueta, $html, $o);
    }

    /** Grupo de opciones excluyentes dentro de un fieldset con leyenda. */
    public static function radios(Documento $doc, string $nombre, string $etiqueta, array $opciones, array $o = []): string
    {
        $actual = $doc->valor($nombre);
        $error = $doc->error($nombre);
        $describe = self::idsDescripcion($nombre, $o, $error);
        $html = '<fieldset class="campo campo--ancho opciones' . ($error ? ' campo--error' : '') . '" id="campo-' . e($nombre) . '"'
            . ($describe ? ' aria-describedby="' . $describe . '"' : '') . '>';
        $html .= '<legend class="campo__etiqueta">' . e($etiqueta) . self::marcaRequerido($o) . '</legend>';
        $html .= self::ayuda($nombre, $o);
        $html .= '<div class="opciones__lista">';
        foreach ($opciones as $valor => $texto) {
            $html .= '<label class="opcion"><input type="radio" name="' . e($nombre) . '" value="' . e($valor) . '"'
                . ((string) $valor === $actual ? ' checked' : '')
                . (!empty($o['requerido']) ? ' required' : '')
                . ($error ? ' aria-invalid="true"' : '')
                . '><span>' . e($texto) . '</span></label>';
        }
        $html .= '</div>' . self::mensajeError($nombre, $error) . '</fieldset>';
        return $html;
    }

    /** Resumen de errores al inicio del formulario, con enlaces a cada campo. */
    public static function resumenErrores(Documento $doc): string
    {
        $errores = $doc->errores();
        if ($errores === []) {
            return '';
        }
        $html = '<div class="alerta alerta--error" role="alert" tabindex="-1" id="resumen-errores">'
            . '<h2 class="alerta__titulo">Revisa ' . (count($errores) === 1 ? 'este dato' : 'estos ' . count($errores) . ' datos')
            . ' para generar tu PDF</h2><ul>';
        foreach ($errores as $campo => $mensaje) {
            $html .= '<li><a href="#campo-' . e($campo) . '">' . e($mensaje) . '</a></li>';
        }
        return $html . '</ul></div>';
    }

    // --- Piezas internas ------------------------------------------------------------------

    private static function envolver(Documento $doc, string $nombre, string $etiqueta, string $control, array $o): string
    {
        $error = $doc->error($nombre);
        $clases = 'campo' . (!empty($o['ancho']) ? ' campo--ancho' : '') . ($error ? ' campo--error' : '');
        return '<div class="' . $clases . '">'
            . '<label class="campo__etiqueta" for="campo-' . e($nombre) . '">' . e($etiqueta) . self::marcaRequerido($o) . '</label>'
            . self::ayuda($nombre, $o)
            . $control
            . self::mensajeError($nombre, $error)
            . '</div>';
    }

    private static function atributos(string $nombre, Documento $doc, array $o): string
    {
        $error = $doc->error($nombre);
        $describe = self::idsDescripcion($nombre, $o, $error);
        return ' id="campo-' . e($nombre) . '"'
            . (!empty($o['requerido']) ? ' required' : '')
            . ($error ? ' aria-invalid="true"' : '')
            . ($describe ? ' aria-describedby="' . $describe . '"' : '');
    }

    private static function idsDescripcion(string $nombre, array $o, ?string $error): string
    {
        $ids = [];
        if (!empty($o['ayuda'])) {
            $ids[] = 'ayuda-' . $nombre;
        }
        if ($error) {
            $ids[] = 'error-' . $nombre;
        }
        return e(implode(' ', $ids));
    }

    private static function ayuda(string $nombre, array $o): string
    {
        return empty($o['ayuda']) ? '' : '<p class="campo__ayuda" id="ayuda-' . e($nombre) . '">' . e($o['ayuda']) . '</p>';
    }

    private static function mensajeError(string $nombre, ?string $error): string
    {
        return $error ? '<p class="campo__mensaje" id="error-' . e($nombre) . '"><span aria-hidden="true">!</span> ' . e($error) . '</p>' : '';
    }

    private static function marcaRequerido(array $o): string
    {
        return !empty($o['requerido']) ? ' <span class="campo__req" aria-hidden="true">*</span>' : '';
    }

    private static function lista(array $atributos): string
    {
        $html = '';
        foreach ($atributos as $clave => $valor) {
            if ($valor !== null && $valor !== '') {
                $html .= ' ' . $clave . '="' . e($valor) . '"';
            }
        }
        return $html;
    }
}
