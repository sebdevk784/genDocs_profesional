<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Modelos\CartaRecomendacion;
use App\Modelos\Documento;

final class CartaRecomendacionControlador extends DocumentoControlador
{
    protected function vista(): string
    {
        return 'carta_recomendacion';
    }

    protected function nuevoDocumento(): Documento
    {
        return new CartaRecomendacion();
    }

    protected function documentoEnviado(): Documento
    {
        return CartaRecomendacion::desdeSolicitud($this->solicitud);
    }

    protected function nombreArchivo(Documento $documento): string
    {
        return Documento::nombreArchivo('carta-de-recomendacion', $documento->valor('nombre_recomendado'));
    }

    protected function seo(): array
    {
        return [
            'titulo' => 'Carta de recomendación personal en PDF gratis | GenDocs',
            'descripcion' => 'Genera una carta de recomendación personal lista para firmar: datos de quien recomienda '
                . 'y de la persona recomendada, redacción según su género y descarga en PDF. Gratis.',
            'ruta' => '/carta-de-recomendacion',
            'migas' => [['Inicio', '/'], ['Carta de recomendación', '/carta-de-recomendacion']],
        ];
    }
}
