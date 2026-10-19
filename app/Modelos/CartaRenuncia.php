<?php
declare(strict_types=1);

namespace App\Modelos;

final class CartaRenuncia extends Documento
{
    protected static function campos(): array
    {
        return [
            'ciudad' => 80, 'fecha' => 10, 'empresa' => 0, 'cargo' => 0,
            'nombre_jefe' => 0, 'genero_jefe' => 10, 'fecha_renuncia' => 10,
            'nombre' => 0, 'genero' => 10, 'tipo_documento' => 5, 'documento' => 20,
            'telefono' => 20,
        ];
    }

    protected static function valoresIniciales(): array
    {
        return ['fecha' => Fecha::hoy(), 'tipo_documento' => 'CC'];
    }

    protected function validar(): void
    {
        $this->requerir('ciudad', 'Escribe la ciudad desde donde envías la carta.');
        $this->exigirFecha('fecha', 'Indica una fecha de redacción válida.');
        $this->requerir('empresa', 'Escribe el nombre de la empresa.');
        $this->exigirOpcion('genero_jefe', Genero::opciones(), 'Elige una opción válida para el destinatario.', false);
        $this->exigirFecha('fecha_renuncia', 'La fecha del último día de trabajo no es válida.', false);
        $this->requerir('nombre', 'Escribe tu nombre completo.');
        $this->exigirOpcion('genero', Genero::opciones(), 'Elige cómo quieres que se redacte la carta: hombre o mujer.');
        $this->exigirOpcion('tipo_documento', self::TIPOS_DOCUMENTO, 'Elige un tipo de documento.');
        $this->exigirNumeroDocumento('documento', 'Escribe tu número de documento (solo números, letras, puntos o guiones).');
        $this->exigirTelefono('telefono', 'Escribe un teléfono válido (7 a 20 dígitos).');

        $redaccion = Fecha::crear($this->valor('fecha'));
        $salida = Fecha::crear($this->valor('fecha_renuncia'));
        if ($redaccion && $salida && $salida < $redaccion) {
            $this->agregarError('fecha_renuncia', 'El último día de trabajo no puede ser anterior a la fecha de la carta.');
        }
    }

    public function genero(): Genero
    {
        return new Genero($this->valor('genero'));
    }

    public function generoJefe(): Genero
    {
        return new Genero($this->valor('genero_jefe'));
    }
}
