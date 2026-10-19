<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Modelos\Documento;
use App\Modelos\HojaVida;

/**
 * Además del flujo común, atiende los botones «Agregar» y «Quitar» de los grupos repetibles
 * cuando el navegador no ejecuta JavaScript: el formulario se envía y vuelve con un grupo más
 * o uno menos, conservando lo escrito.
 */
final class HojaVidaControlador extends DocumentoControlador
{
    public function generar(): void
    {
        $agregar = $this->solicitud->texto('agregar');
        $quitar = $this->solicitud->texto('quitar');
        if ($agregar === '' && $quitar === '') {
            parent::generar();
            return;
        }

        /** @var HojaVida $hoja */
        $hoja = $this->documentoEnviado();
        if ($agregar !== '') {
            $hoja->agregarGrupo($agregar);
        } elseif (preg_match('/^([a-z_]+):(\d+)$/', $quitar, $partes)) {
            $hoja->quitarGrupo($partes[1], (int) $partes[2]);
        }
        $this->mostrarFormulario($hoja);
    }

    protected function vista(): string
    {
        return 'hoja_vida';
    }

    protected function vistaPdf(Documento $documento): string
    {
        /** @var HojaVida $documento */
        return $documento->vistaPdf();
    }

    protected function nuevoDocumento(): Documento
    {
        return new HojaVida();
    }

    protected function documentoEnviado(): Documento
    {
        $hoja = HojaVida::desdeSolicitud($this->solicitud);
        $hoja->adjuntarFoto($this->solicitud->archivo('foto'));
        return $hoja;
    }

    protected function nombreArchivo(Documento $documento): string
    {
        return Documento::nombreArchivo('hoja-de-vida', $documento->valor('nombre'));
    }

    protected function seo(): array
    {
        return [
            'titulo' => 'Hoja de vida en PDF gratis, formato Colombia | GenDocs',
            'descripcion' => 'Crea tu hoja de vida en PDF con foto, formación, experiencia y referencias. '
                . 'Formato colombiano, perfil profesional adaptado a tu género y descarga gratis sin registro.',
            'ruta' => '/hoja-de-vida',
            'migas' => [['Inicio', '/'], ['Hoja de vida', '/hoja-de-vida']],
        ];
    }
}
