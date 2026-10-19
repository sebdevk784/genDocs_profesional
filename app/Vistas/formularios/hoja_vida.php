<?php
/**
 * Formulario de la hoja de vida. Todos los ejemplos (placeholders) son datos sintéticos.
 *
 * @var App\Modelos\HojaVida $documento
 * @var array $seo
 */
use App\Modelos\Documento;
use App\Modelos\Genero;
use App\Modelos\HojaVida;
use App\Nucleo\Formulario as F;
use App\Nucleo\Vista;

$d = $documento;
$estadosCiviles = array_map(static function (array $formas): string {
    return $formas[0] === $formas[1] ? $formas[0] : $formas[0] . ' / ' . $formas[1];
}, HojaVida::ESTADOS_CIVILES);
$plantillas = [
    'clasica' => ['Clásica', 'Una columna, sobria y fácil de leer. Ideal para cualquier empleo.', 'img/vistas/hoja-de-vida.png'],
    'dos_columnas' => ['Dos columnas', 'Barra lateral oscura con foto, contacto y referencias. Destaca experiencia y proyectos.', 'img/vistas/hoja-de-vida-dos-columnas.png'],
];
$errorPlantilla = $d->error('plantilla');

echo Vista::parcial('parciales/encabezado', [
    'seo' => $seo,
    'titulo' => 'Crea tu hoja de vida en PDF',
    'entrada' => 'Elige un diseño y completa solo lo que necesites: los datos y las secciones que dejes vacíos no aparecen en el PDF.',
]);
?>
<div class="contenedor diseno-formulario">
    <form class="formulario" method="post" action="<?= e(url('/hoja-de-vida')) ?>#resumen-errores" enctype="multipart/form-data">
        <p class="formulario__nota">Los campos marcados con <span class="campo__req" aria-hidden="true">*</span><span class="visualmente-oculto">asterisco</span> son obligatorios.</p>
        <?= F::resumenErrores($d) ?>

        <section class="bloque" aria-labelledby="titulo-diseno">
            <h2 class="bloque__titulo" id="titulo-diseno"><?= icono('documento') ?>Diseño</h2>
            <fieldset class="campo campo--ancho plantillas<?= $errorPlantilla ? ' campo--error' : '' ?>" id="campo-plantilla">
                <legend class="campo__etiqueta">Elige el diseño de tu hoja de vida <span class="campo__req" aria-hidden="true">*</span></legend>
                <div class="plantillas__lista">
<?php foreach ($plantillas as $valor => [$nombre, $descripcion, $imagen]): ?>
                    <label class="plantilla">
                        <input type="radio" name="plantilla" value="<?= e($valor) ?>" required<?= $d->valor('plantilla') === $valor ? ' checked' : '' ?>>
                        <span class="plantilla__tarjeta">
                            <img src="<?= e(recurso($imagen)) ?>" alt="" width="816" height="1056" loading="lazy" decoding="async">
                            <span class="plantilla__nombre"><?= e($nombre) ?></span>
                            <span class="plantilla__texto"><?= e($descripcion) ?></span>
                        </span>
                    </label>
<?php endforeach ?>
                </div>
                <?= Vista::parcial('parciales/aviso', [
                    'titulo' => 'Diseño «Dos columnas»:',
                    'texto' => 'la barra lateral tiene espacio para unas 5 referencias en total (familiares y personales) en la primera página. Si vas a incluir más, elige el diseño «Clásica».',
                ]) ?>
<?php if ($errorPlantilla): ?>
                <p class="campo__mensaje" id="error-plantilla"><span aria-hidden="true">!</span> <?= e($errorPlantilla) ?></p>
<?php endif ?>
            </fieldset>
        </section>

        <section class="bloque" aria-labelledby="titulo-personales">
            <h2 class="bloque__titulo" id="titulo-personales"><?= icono('usuario') ?>Datos personales</h2>
            <div class="rejilla">
                <?= F::texto($d, 'nombre', 'Nombre completo', ['requerido' => true, 'ancho' => true, 'autocomplete' => 'name', 'placeholder' => 'Ej.: Sebastián Echavarría']) ?>
                <?= F::radios($d, 'genero', '¿Cómo quieres que se redacte tu hoja de vida?', Genero::opciones(), ['requerido' => true, 'ayuda' => 'Ajusta el perfil sugerido y el estado civil: «proactivo» o «proactiva», «soltero» o «soltera».']) ?>
                <?= F::texto($d, 'profesion', 'Profesión u ocupación', ['ancho' => true, 'autocomplete' => 'organization-title', 'placeholder' => 'Ej.: Auxiliar contable', 'ayuda' => 'Aparece debajo de tu nombre.']) ?>
                <?= F::seleccion($d, 'tipo_documento', 'Tipo de documento', Documento::TIPOS_DOCUMENTO, ['requerido' => true]) ?>
                <?= F::texto($d, 'documento', 'Número de documento', ['inputmode' => 'numeric', 'max' => 20, 'placeholder' => 'Ej.: 1111111111']) ?>
                <?= F::texto($d, 'expedicion', 'Lugar de expedición', ['max' => 80, 'placeholder' => 'Ej.: Rionegro', 'ayuda' => 'Se imprime como «CC 1111111111 de Rionegro».']) ?>
                <?= F::texto($d, 'fecha_nacimiento', 'Fecha de nacimiento', ['tipo' => 'date', 'autocomplete' => 'bday']) ?>
                <?= F::seleccion($d, 'estado_civil', 'Estado civil', $estadosCiviles, ['vacia' => 'Prefiero no indicarlo']) ?>
                <?= F::texto($d, 'ciudad', 'Ciudad', ['autocomplete' => 'address-level2', 'max' => 80, 'placeholder' => 'Ej.: Rionegro, Antioquia']) ?>
                <?= F::texto($d, 'direccion', 'Dirección', ['autocomplete' => 'street-address', 'placeholder' => 'Ej.: Calle 11 # 11-11']) ?>
                <?= F::texto($d, 'barrio', 'Barrio', ['placeholder' => 'Ej.: <<NOMBRE_BARRIO>>']) ?>
                <?= F::texto($d, 'celular', 'Celular', ['tipo' => 'tel', 'inputmode' => 'tel', 'autocomplete' => 'tel', 'max' => 20, 'placeholder' => 'Ej.: 311 111 1111']) ?>
                <?= F::texto($d, 'correo', 'Correo electrónico', ['tipo' => 'email', 'autocomplete' => 'email', 'placeholder' => 'Ej.: nombre.apellido@example.com']) ?>
                <?= F::texto($d, 'enlace_profesional', 'Enlace a tu perfil profesional', ['inputmode' => 'url', 'placeholder' => 'Ej.: <<ENLACE_PERFIL_PROFESIONAL>>']) ?>
                <?= F::texto($d, 'sitio_web', 'Sitio web o portafolio', ['inputmode' => 'url', 'placeholder' => 'Ej.: sebasdev784.com.co']) ?>
                <?= F::texto($d, 'foto', 'Foto tipo documento (JPG)', ['tipo' => 'file', 'accept' => '.jpg,.jpeg,image/jpeg', 'ancho' => true, 'ayuda' => 'Opcional. Máximo 2 MB, fondo claro. Si la página se recarga, vuelve a seleccionarla.']) ?>
                <?= Vista::parcial('parciales/aviso', [
                    'titulo' => 'Solo fotos JPG:',
                    'texto' => 'para evitar problemas al generar el PDF, la foto debe estar en formato JPG (.jpg o .jpeg). Si tu foto es PNG u otro formato, ábrela y guárdala como JPG antes de subirla.',
                ]) ?>
            </div>
        </section>

        <section class="bloque" aria-labelledby="titulo-perfil">
            <h2 class="bloque__titulo" id="titulo-perfil"><?= icono('lapiz') ?>Perfil profesional</h2>
            <div class="rejilla">
                <?= F::area($d, 'perfil', 'Describe en pocas líneas quién eres y qué buscas', ['filas' => 5, 'ayuda' => 'Opcional. En el diseño «Dos columnas» aparece como «Sobre mí».', 'placeholder' => 'Ej.: Auxiliar contable con dos años de experiencia en facturación y conciliaciones bancarias…']) ?>
                <label class="casilla campo--ancho">
                    <input type="checkbox" name="perfil_sugerido" value="1"<?= $d->valor('perfil_sugerido') === '1' ? ' checked' : '' ?>>
                    <span>Si dejo el perfil vacío, usar uno sugerido redactado según mi género. Desmárcalo para que la sección no aparezca.</span>
                </label>
            </div>
        </section>

        <?= Vista::parcial('parciales/repetible', [
            'documento' => $d, 'grupo' => 'formacion', 'titulo' => 'Formación académica', 'icono' => 'birrete',
            'singular' => 'Estudio', 'ayuda' => 'Empieza por el más reciente.',
            'campos' => [
                'institucion' => ['Institución educativa', ['ancho' => true, 'placeholder' => 'Ej.: <<NOMBRE_INSTITUCION>>']],
                'titulo' => ['Título obtenido', ['placeholder' => 'Ej.: Bachiller académico']],
                'anio' => ['Año de grado', ['max' => 12, 'placeholder' => 'Ej.: 2022 o En curso']],
            ],
        ]) ?>

        <?= Vista::parcial('parciales/repetible', [
            'documento' => $d, 'grupo' => 'experiencia', 'titulo' => 'Experiencia laboral', 'icono' => 'maletin',
            'singular' => 'Experiencia', 'ayuda' => 'Empieza por la más reciente. Si es tu primer empleo, deja esta sección vacía y no aparecerá.',
            'campos' => [
                'empresa' => ['Empresa', ['ancho' => true, 'placeholder' => 'Ej.: <<NOMBRE_EMPRESA>>']],
                'cargo' => ['Cargo', ['placeholder' => 'Ej.: Auxiliar de bodega']],
                'jefe' => ['Jefe inmediato', ['placeholder' => 'Ej.: Bastián Echavarría']],
                'telefono' => ['Teléfono de la empresa', ['tipo' => 'tel', 'inputmode' => 'tel', 'max' => 20, 'placeholder' => 'Ej.: 604 111 1111']],
                'duracion' => ['Tiempo laborado', ['inputmode' => 'numeric', 'max' => 2, 'placeholder' => 'Ej.: 2']],
                'unidad' => ['Unidad', ['opciones' => HojaVida::UNIDADES_DURACION]],
                'descripcion' => ['Funciones y logros', ['ancho' => true, 'area' => true, 'placeholder' => 'Ej.: Recepción y despacho de mercancía, control de inventario y atención a proveedores.']],
            ],
        ]) ?>

        <?= Vista::parcial('parciales/repetible', [
            'documento' => $d, 'grupo' => 'proyectos', 'titulo' => 'Proyectos', 'icono' => 'bombilla',
            'singular' => 'Proyecto', 'ayuda' => 'Opcional: trabajos de grado, emprendimientos o proyectos destacados.',
            'campos' => [
                'nombre' => ['Nombre del proyecto', ['ancho' => true, 'placeholder' => 'Ej.: GenDocs, generador de documentos en PDF']],
                'descripcion' => ['Descripción', ['ancho' => true, 'area' => true, 'placeholder' => 'Ej.: Qué hiciste, con qué herramientas y qué resultado obtuviste.']],
            ],
        ]) ?>

        <?= Vista::parcial('parciales/repetible', [
            'documento' => $d, 'grupo' => 'referencias_familiares', 'titulo' => 'Referencias familiares', 'icono' => 'personas',
            'singular' => 'Referencia', 'ayuda' => 'Familiares que puedan dar información sobre ti.',
            'campos' => [
                'nombre' => ['Nombre', ['ancho' => true, 'placeholder' => 'Ej.: Tiana Echavarría']],
                'parentesco' => ['Parentesco', ['placeholder' => 'Ej.: Madre, hermano, prima']],
                'ocupacion' => ['Ocupación', ['placeholder' => 'Ej.: Comerciante']],
                'celular' => ['Celular', ['tipo' => 'tel', 'inputmode' => 'tel', 'max' => 20, 'placeholder' => 'Ej.: 311 111 1111']],
            ],
        ]) ?>

        <?= Vista::parcial('parciales/repetible', [
            'documento' => $d, 'grupo' => 'referencias_personales', 'titulo' => 'Referencias personales', 'icono' => 'personas',
            'singular' => 'Referencia', 'ayuda' => 'Personas que no sean familiares y te conozcan bien.',
            'campos' => [
                'nombre' => ['Nombre', ['ancho' => true, 'placeholder' => 'Ej.: Sebas Echavarría']],
                'ocupacion' => ['Ocupación', ['placeholder' => 'Ej.: Docente']],
                'celular' => ['Celular', ['tipo' => 'tel', 'inputmode' => 'tel', 'max' => 20, 'placeholder' => 'Ej.: 311 111 1111']],
            ],
        ]) ?>

        <?= Vista::parcial('parciales/enviar', ['texto' => 'Descargar hoja de vida en PDF']) ?>
    </form>

    <?= Vista::parcial('parciales/lateral', [
        'imagen' => 'img/vistas/hoja-de-vida.png',
        'alt' => 'Ejemplo de hoja de vida con datos ficticios',
        'consejos' => [
            ['Usa un correo serio,', 'idealmente con tu nombre y apellido.'],
            ['La foto suma:', 'fondo claro, rostro de frente y buena luz.'],
            ['Pide permiso', 'a tus referencias antes de incluirlas y verifica sus números.'],
            ['Lo que dejes vacío no aparece:', 'no hace falta llenar todas las secciones.'],
        ],
    ]) ?>
</div>
