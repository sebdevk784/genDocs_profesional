<?php
/**
 * Portada.
 *
 * @var array $preguntas
 */
$documentos = [
    [
        'titulo' => 'Hoja de vida',
        'ruta' => '/hoja-de-vida',
        'imagen' => 'img/vistas/hoja-de-vida.png',
        'alt' => 'Vista previa de una hoja de vida generada con GenDocs',
        'descripcion' => 'Dos diseños, clásico o a dos columnas, con foto, perfil, formación, experiencia, proyectos y referencias.',
        'incluye' => ['Elige entre dos diseños profesionales', 'Perfil sugerido según tu género', 'Lo que dejes vacío no aparece en el PDF'],
        'accion' => 'Crear hoja de vida',
    ],
    [
        'titulo' => 'Carta de renuncia',
        'ruta' => '/carta-de-renuncia',
        'imagen' => 'img/vistas/carta-de-renuncia.png',
        'alt' => 'Vista previa de una carta de renuncia generada con GenDocs',
        'descripcion' => 'Renuncia voluntaria formal y cordial, dirigida a la empresa y a tu jefe inmediato.',
        'incluye' => ['Fecha de tu último día de trabajo', 'Saludo según el destinatario', 'Espacio para firma'],
        'accion' => 'Redactar carta de renuncia',
    ],
    [
        'titulo' => 'Carta de recomendación',
        'ruta' => '/carta-de-recomendacion',
        'imagen' => 'img/vistas/carta-de-recomendacion.png',
        'alt' => 'Vista previa de una carta de recomendación personal generada con GenDocs',
        'descripcion' => 'Recomendación personal firmada por alguien que te conoce, lista para adjuntar a tu hoja de vida.',
        'incluye' => ['Tiempo de conocerse bien redactado', 'Datos de quien recomienda', 'Redacción según el género de cada persona'],
        'accion' => 'Crear carta de recomendación',
    ],
];

$beneficios = [
    ['regalo', 'Gratis y sin registro', 'No pagas, no creas cuenta y no ves publicidad: llenas el formulario y descargas.'],
    ['escudo', 'Tus datos no se guardan', 'La información se usa solo para crear el PDF y se descarta enseguida. No hay base de datos.'],
    ['personas', 'Redacción según tu género', 'Eliges hombre o mujer y el documento usa la forma correcta: «identificado» o «identificada».'],
    ['maletin', 'Formato profesional', 'Estructura y tono formales usados en Colombia, con tipos de documento como CC, CE, PPT y PEP.'],
    ['texto', 'Accesible', 'Cambia el tamaño de la letra, activa el modo oscuro y navega con teclado o lector de pantalla.'],
    ['celular', 'Desde cualquier dispositivo', 'Funciona en celular, tableta y computador, incluso con conexiones lentas.'],
];
?>
<section class="banda portada" aria-labelledby="titulo-portada">
    <div class="contenedor portada__rejilla">
        <div>
            <p class="antetitulo">Gratis · Sin registro · Descarga en PDF</p>
            <h1 id="titulo-portada">Tu hoja de vida y tus cartas laborales, <span class="resaltado">listas en minutos</span></h1>
            <p class="lead">Completa un formulario sencillo y descarga documentos con formato profesional, listos para imprimir, firmar o enviar por correo. Redactados en el género que elijas.</p>
            <div class="portada__acciones">
                <a class="btn btn--primario btn--grande" href="<?= e(url('/hoja-de-vida')) ?>"><?= icono('lapiz') ?>Crear mi hoja de vida</a>
                <a class="btn btn--grande" href="#documentos">Ver todos los documentos</a>
            </div>
            <ul class="chips" aria-label="Características">
                <li class="chip"><?= icono('check') ?>Formato colombiano</li>
                <li class="chip"><?= icono('check') ?>Hombre o mujer</li>
                <li class="chip"><?= icono('check') ?>Modo oscuro y letra grande</li>
            </ul>
        </div>
        <div class="portada__visual" aria-hidden="true">
            <figure class="hoja hoja--atras"><img src="<?= e(recurso('img/vistas/carta-de-renuncia.png')) ?>" alt="" width="816" height="1056" decoding="async"></figure>
            <figure class="hoja hoja--frente"><img src="<?= e(recurso('img/vistas/hoja-de-vida.png')) ?>" alt="" width="816" height="1056" fetchpriority="high" decoding="async"></figure>
        </div>
    </div>
</section>

<section class="seccion" id="documentos" aria-labelledby="titulo-documentos">
    <div class="contenedor">
        <div class="seccion__cabeza">
            <p class="antetitulo">Documentos disponibles</p>
            <h2 id="titulo-documentos">Elige el documento que necesitas</h2>
            <p class="lead">Las vistas previas usan datos ficticios: cualquier parecido con la realidad es coincidencia.</p>
        </div>
        <div class="rejilla-tarjetas">
<?php foreach ($documentos as $doc): ?>
            <article class="tarjeta tarjeta--doc">
                <div class="tarjeta__media">
                    <img src="<?= e(recurso($doc['imagen'])) ?>" alt="<?= e($doc['alt']) ?>" width="816" height="1056" loading="lazy" decoding="async">
                </div>
                <div class="tarjeta__cuerpo">
                    <h3><?= e($doc['titulo']) ?></h3>
                    <p><?= e($doc['descripcion']) ?></p>
                    <ul class="tarjeta__lista">
<?php foreach ($doc['incluye'] as $item): ?>
                        <li><?= icono('check') ?><span><?= e($item) ?></span></li>
<?php endforeach ?>
                    </ul>
                    <a class="btn btn--primario tarjeta__accion tarjeta__enlace" href="<?= e(url($doc['ruta'])) ?>"><?= e($doc['accion']) ?><?= icono('flecha') ?></a>
                </div>
            </article>
<?php endforeach ?>
        </div>
    </div>
</section>

<section class="seccion seccion--alterna" aria-labelledby="titulo-pasos">
    <div class="contenedor">
        <div class="seccion__cabeza seccion__cabeza--centro">
            <p class="antetitulo">Cómo funciona</p>
            <h2 id="titulo-pasos">Tres pasos y tu documento está listo</h2>
        </div>
        <ol class="pasos">
            <li class="paso">
                <h3>Elige el documento</h3>
                <p>Hoja de vida, carta de renuncia o carta de recomendación personal.</p>
            </li>
            <li class="paso">
                <h3>Completa el formulario</h3>
                <p>Escribe tus datos y elige si el texto se redacta para hombre o para mujer.</p>
            </li>
            <li class="paso">
                <h3>Descarga tu PDF</h3>
                <p>El archivo se genera al instante, listo para imprimir, firmar o enviar.</p>
            </li>
        </ol>
    </div>
</section>

<section class="seccion" aria-labelledby="titulo-beneficios">
    <div class="contenedor">
        <div class="seccion__cabeza">
            <p class="antetitulo">Por qué GenDocs</p>
            <h2 id="titulo-beneficios">Pensado para que busques empleo sin complicaciones</h2>
        </div>
        <ul class="beneficios">
<?php foreach ($beneficios as [$icono, $titulo, $texto]): ?>
            <li class="beneficio">
                <span class="beneficio__icono"><?= icono($icono) ?></span>
                <div>
                    <h3><?= e($titulo) ?></h3>
                    <p><?= e($texto) ?></p>
                </div>
            </li>
<?php endforeach ?>
        </ul>
    </div>
</section>

<section class="seccion seccion--alterna" aria-labelledby="titulo-preguntas">
    <div class="contenedor">
        <div class="seccion__cabeza seccion__cabeza--centro">
            <p class="antetitulo">Preguntas frecuentes</p>
            <h2 id="titulo-preguntas">Resolvemos tus dudas</h2>
        </div>
        <div class="preguntas">
<?php foreach ($preguntas as $p): ?>
            <details class="pregunta">
                <summary><?= e($p['pregunta']) ?></summary>
                <p><?= e($p['respuesta']) ?></p>
            </details>
<?php endforeach ?>
        </div>
    </div>
</section>

<section class="seccion" aria-labelledby="titulo-llamado">
    <div class="contenedor">
        <div class="llamado">
            <h2 id="titulo-llamado">Da el siguiente paso en tu carrera</h2>
            <p>Tu próxima entrevista empieza con un buen documento. Créalo ahora, sin costo.</p>
            <div class="llamado__acciones">
                <a class="btn btn--primario btn--grande" href="<?= e(url('/hoja-de-vida')) ?>"><?= icono('descarga') ?>Crear hoja de vida</a>
                <a class="btn btn--grande" href="<?= e(url('/carta-de-renuncia')) ?>">Carta de renuncia</a>
                <a class="btn btn--grande" href="<?= e(url('/carta-de-recomendacion')) ?>">Carta de recomendación</a>
            </div>
        </div>
    </div>
</section>
