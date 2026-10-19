<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Modelos\PreguntasFrecuentes;
use App\Nucleo\Controlador;

final class InicioControlador extends Controlador
{
    public function index(): void
    {
        $preguntas = PreguntasFrecuentes::todas();
        $this->mostrar('inicio/index', [
            'preguntas' => $preguntas,
            'seo' => [
                'titulo' => 'GenDocs | Hoja de vida y cartas laborales en PDF gratis',
                'descripcion' => 'Crea gratis tu hoja de vida, carta de renuncia o carta de recomendación personal '
                    . 'en PDF. Sin registro, formato profesional colombiano y redacción adaptada a tu género.',
                'ruta' => '/',
                'datos_estructurados' => [$this->aplicacionWeb(), $this->faq($preguntas)],
            ],
        ]);
    }

    private function aplicacionWeb(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            'name' => 'GenDocs',
            'url' => url_publica('/'),
            'description' => 'Generador gratuito de hojas de vida, cartas de renuncia y cartas de recomendación personal en PDF.',
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Cualquiera (navegador web)',
            'inLanguage' => 'es-CO',
            'isAccessibleForFree' => true,
            'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'COP'],
            'featureList' => [
                'Hoja de vida en PDF con foto',
                'Carta de renuncia voluntaria',
                'Carta de recomendación personal',
                'Redacción adaptada al género',
                'Modo oscuro y tamaño de letra ajustable',
            ],
            'author' => [
                '@type' => 'Person',
                'name' => config('autor.nombre'),
                'alternateName' => config('autor.alias'),
                'url' => config('autor.sitio'),
                'sameAs' => [config('autor.sitio'), config('autor.github'), config('autor.instagram')],
            ],
        ];
    }

    private function faq(array $preguntas): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static function (array $p): array {
                return [
                    '@type' => 'Question',
                    'name' => $p['pregunta'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $p['respuesta']],
                ];
            }, $preguntas),
        ];
    }
}
