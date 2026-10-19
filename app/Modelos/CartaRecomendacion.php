<?php
declare(strict_types=1);

namespace App\Modelos;

final class CartaRecomendacion extends Documento
{
    public const UNIDADES_TIEMPO = ['anios' => 'Años', 'meses' => 'Meses'];

    protected static function campos(): array
    {
        return [
            'ciudad' => 80, 'fecha' => 10,
            'nombre_recomendado' => 0, 'genero_recomendado' => 10,
            'tipo_documento_recomendado' => 5, 'documento_recomendado' => 20,
            'tiempo' => 2, 'unidad_tiempo' => 10,
            'nombre' => 0, 'genero' => 10, 'tipo_documento' => 5, 'documento' => 20, 'telefono' => 20,
        ];
    }

    protected static function valoresIniciales(): array
    {
        return [
            'fecha' => Fecha::hoy(), 'tipo_documento' => 'CC', 'tipo_documento_recomendado' => 'CC',
            'unidad_tiempo' => 'anios',
        ];
    }

    protected function validar(): void
    {
        $this->requerir('ciudad', 'Escribe la ciudad desde donde se firma la carta.');
        $this->exigirFecha('fecha', 'Indica una fecha de redacción válida.');
        $this->requerir('nombre_recomendado', 'Escribe el nombre de la persona recomendada.');
        $this->exigirOpcion('genero_recomendado', Genero::opciones(), 'Elige si la persona recomendada es hombre o mujer.');
        $this->exigirOpcion('tipo_documento_recomendado', self::TIPOS_DOCUMENTO, 'Elige el tipo de documento de la persona recomendada.');
        $this->exigirNumeroDocumento('documento_recomendado', 'Escribe el número de documento de la persona recomendada.');
        $this->exigirPatron('tiempo', '/^(?:[1-9]|[1-9][0-9])$/', 'Indica cuánto tiempo llevan de conocerse (1 a 99).', true);
        $this->exigirOpcion('unidad_tiempo', self::UNIDADES_TIEMPO, 'Elige años o meses.');
        $this->requerir('nombre', 'Escribe el nombre de quien recomienda.');
        $this->exigirOpcion('genero', Genero::opciones(), 'Elige si quien recomienda es hombre o mujer.');
        $this->exigirOpcion('tipo_documento', self::TIPOS_DOCUMENTO, 'Elige el tipo de documento de quien recomienda.');
        $this->exigirNumeroDocumento('documento', 'Escribe el número de documento de quien recomienda.');
        $this->exigirTelefono('telefono', 'Escribe un teléfono válido (7 a 20 dígitos).', true);
    }

    public function genero(): Genero
    {
        return new Genero($this->valor('genero'));
    }

    public function generoRecomendado(): Genero
    {
        return new Genero($this->valor('genero_recomendado'));
    }

    /** «el último año», «los últimos 5 años», «los últimos 8 meses». */
    public function tiempoConocidos(): string
    {
        $cantidad = (int) $this->valor('tiempo');
        $meses = $this->valor('unidad_tiempo') === 'meses';
        if ($cantidad === 1) {
            return $meses ? 'el último mes' : 'el último año';
        }
        return 'los últimos ' . $cantidad . ($meses ? ' meses' : ' años');
    }
}
