<?php
declare(strict_types=1);

namespace App\Modelos;

use App\Nucleo\Config;
use App\Nucleo\Solicitud;

/**
 * Base de los documentos: datos del formulario, validación y mensajes de error por campo.
 * Los datos nunca se guardan: viven solo durante la petición que genera el PDF.
 */
abstract class Documento
{
    public const TIPOS_DOCUMENTO = [
        'CC' => 'Cédula de ciudadanía',
        'CE' => 'Cédula de extranjería',
        'PPT' => 'Permiso por Protección Temporal',
        'PEP' => 'Permiso Especial de Permanencia',
        'PA' => 'Pasaporte',
    ];

    /** Cómo se nombra cada tipo dentro de una frase: «identificado con cédula de ciudadanía n.° …». */
    private const TIPOS_DOCUMENTO_EN_TEXTO = [
        'CC' => 'cédula de ciudadanía',
        'CE' => 'cédula de extranjería',
        'PPT' => 'Permiso por Protección Temporal (PPT)',
        'PEP' => 'Permiso Especial de Permanencia (PEP)',
        'PA' => 'pasaporte',
    ];

    protected array $datos;
    protected array $errores = [];

    public function __construct(array $datos = [])
    {
        $this->datos = $datos + static::valoresIniciales();
    }

    /** Campos de texto del formulario => longitud máxima (0 = límite general). */
    abstract protected static function campos(): array;

    abstract protected function validar(): void;

    protected static function valoresIniciales(): array
    {
        return [];
    }

    /** @return static */
    public static function desdeSolicitud(Solicitud $solicitud)
    {
        $limite = (int) Config::obtener('limites.texto');
        $datos = [];
        foreach (static::campos() as $campo => $maximo) {
            $datos[$campo] = $solicitud->texto($campo, $maximo ?: $limite);
        }
        return new static($datos);
    }

    public function valor(string $campo): string
    {
        return (string) ($this->datos[$campo] ?? '');
    }

    public function error(string $campo): ?string
    {
        return $this->errores[$campo] ?? null;
    }

    public function errores(): array
    {
        return $this->errores;
    }

    public function esValido(): bool
    {
        $this->errores = [];
        $this->validar();
        return $this->errores === [];
    }

    /** Tipo de documento para usar dentro de una frase. */
    public function tipoDocumentoEnTexto(string $campo = 'tipo_documento'): string
    {
        return self::TIPOS_DOCUMENTO_EN_TEXTO[$this->valor($campo)] ?? 'documento de identidad';
    }

    /** Nombre seguro para el PDF descargado: carta-de-renuncia-ana-perez.pdf */
    public static function nombreArchivo(string $prefijo, string $nombre): string
    {
        $slug = self::slug($nombre);
        return $prefijo . ($slug !== '' ? '-' . $slug : '') . '.pdf';
    }

    public static function slug(string $texto): string
    {
        $texto = strtr(mb_strtolower($texto), [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n',
            'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u', 'ç' => 'c',
        ]);
        return trim((string) preg_replace('/[^a-z0-9]+/', '-', $texto), '-');
    }

    // --- Reglas de validación -------------------------------------------------------------

    protected function agregarError(string $campo, string $mensaje): void
    {
        $this->errores[$campo] ??= $mensaje;
    }

    protected function requerir(string $campo, string $mensaje): bool
    {
        if ($this->valor($campo) === '') {
            $this->agregarError($campo, $mensaje);
            return false;
        }
        return true;
    }

    protected function exigirOpcion(string $campo, array $opciones, string $mensaje, bool $requerido = true): void
    {
        $valor = $this->valor($campo);
        if (($valor !== '' || $requerido) && !array_key_exists($valor, $opciones)) {
            $this->agregarError($campo, $mensaje);
        }
    }

    protected function exigirFecha(string $campo, string $mensaje, bool $requerido = true): void
    {
        $valor = $this->valor($campo);
        if (($valor !== '' || $requerido) && !Fecha::esValida($valor)) {
            $this->agregarError($campo, $mensaje);
        }
    }

    protected function exigirNumeroDocumento(string $campo, string $mensaje, bool $requerido = true): void
    {
        $this->exigirPatron($campo, '/^[0-9A-Za-z.\- ]{4,20}$/', $mensaje, $requerido);
    }

    protected function exigirTelefono(string $campo, string $mensaje, bool $requerido = false): void
    {
        $this->exigirPatron($campo, '/^\+?[0-9() \-]{7,20}$/', $mensaje, $requerido);
    }

    protected function exigirCorreo(string $campo, string $mensaje, bool $requerido = false): void
    {
        $valor = $this->valor($campo);
        if (($valor !== '' || $requerido) && filter_var($valor, FILTER_VALIDATE_EMAIL) === false) {
            $this->agregarError($campo, $mensaje);
        }
    }

    protected function exigirPatron(string $campo, string $patron, string $mensaje, bool $requerido): void
    {
        $valor = $this->valor($campo);
        if (($valor !== '' || $requerido) && !preg_match($patron, $valor)) {
            $this->agregarError($campo, $mensaje);
        }
    }
}
