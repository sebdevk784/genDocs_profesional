<?php
declare(strict_types=1);

namespace App\Modelos;

/**
 * Preguntas frecuentes de la portada. Se muestran en la página y se publican como datos
 * estructurados FAQPage (schema.org) a partir de la misma fuente.
 */
final class PreguntasFrecuentes
{
    public static function todas(): array
    {
        return [
            [
                'pregunta' => '¿GenDocs es gratis?',
                'respuesta' => 'Sí. Puedes crear y descargar todas las hojas de vida y cartas que necesites sin pagar y sin crear una cuenta.',
            ],
            [
                'pregunta' => '¿Guardan mis datos personales?',
                'respuesta' => 'No. Los datos del formulario se usan únicamente para generar tu PDF en ese momento y se descartan al terminar la descarga. No hay base de datos ni registro de usuarios.',
            ],
            [
                'pregunta' => '¿Para qué sirve elegir si soy hombre o mujer?',
                'respuesta' => 'Para que el documento quede bien redactado en español: «identificado» o «identificada», «soltero» o «soltera», «conocerlo» o «conocerla». Así evitas las formas con «(a)» que restan formalidad.',
            ],
            [
                'pregunta' => '¿Tengo que llenar todos los campos?',
                'respuesta' => 'No. Solo los marcados con asterisco son obligatorios. Los datos y las secciones que dejes vacíos, como la experiencia laboral o las referencias, no aparecen en el documento.',
            ],
            [
                'pregunta' => '¿Qué diseños de hoja de vida hay?',
                'respuesta' => 'Dos: «Clásica», a una columna y fácil de leer, y «Dos columnas», con una barra lateral para la foto, el contacto y las referencias, que destaca la experiencia y los proyectos.',
            ],
            [
                'pregunta' => '¿Qué necesito para hacer mi carta de renuncia?',
                'respuesta' => 'El nombre de la empresa, tu nombre completo, tu tipo y número de documento y, si quieres, el nombre de tu jefe inmediato, tu cargo y tu último día de trabajo.',
            ],
            [
                'pregunta' => '¿Puedo editar el PDF después de descargarlo?',
                'respuesta' => 'El PDF queda listo para imprimir, firmar o enviar. Si necesitas un cambio, vuelve al formulario, corrige el dato y descárgalo otra vez: toma menos de un minuto.',
            ],
            [
                'pregunta' => '¿Funciona desde el celular?',
                'respuesta' => 'Sí. El sitio se adapta a celulares y tabletas, y puedes cambiar el tamaño de la letra o activar el modo oscuro desde la parte superior de la página.',
            ],
        ];
    }
}
