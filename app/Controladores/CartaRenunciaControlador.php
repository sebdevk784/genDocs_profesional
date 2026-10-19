<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Modelos\CartaRenuncia;
use App\Modelos\Documento;

final class CartaRenunciaControlador extends DocumentoControlador
{
    protected function vista(): string
    {
        return 'carta_renuncia';
    }

    protected function nuevoDocumento(): Documento
    {
        return new CartaRenuncia();
    }

    protected function documentoEnviado(): Documento
    {
        return CartaRenuncia::desdeSolicitud($this->solicitud);
    }

    protected function nombreArchivo(Documento $documento): string
    {
        return Documento::nombreArchivo('carta-de-renuncia', $documento->valor('nombre'));
    }

    protected function seo(): array
    {
        return [
            'titulo' => 'Carta de renuncia voluntaria en PDF gratis | GenDocs',
            'descripcion' => 'Redacta tu carta de renuncia voluntaria en minutos: formato formal usado en Colombia, '
                . 'redacción adaptada a tu género y descarga inmediata en PDF. Gratis y sin registro.',
            'ruta' => '/carta-de-renuncia',
            'migas' => [['Inicio', '/'], ['Carta de renuncia', '/carta-de-renuncia']],
        ];
    }
}
