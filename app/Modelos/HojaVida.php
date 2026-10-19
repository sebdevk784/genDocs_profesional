<?php
declare(strict_types=1);

namespace App\Modelos;

use App\Nucleo\Config;
use App\Nucleo\Solicitud;

/**
 * Hoja de vida: datos personales, foto opcional, plantilla elegida y cinco grupos repetibles
 * (formación, experiencia, proyectos, referencias familiares y personales).
 * En el formulario cada grupo se envía como columnas paralelas: formacion[institucion][].
 * Regla de presentación: un dato vacío no se imprime, y un grupo sin datos tampoco imprime su título.
 */
final class HojaVida extends Documento
{
    public const GRUPOS = [
        'formacion' => ['institucion', 'titulo', 'anio'],
        'experiencia' => ['empresa', 'cargo', 'jefe', 'telefono', 'duracion', 'unidad', 'descripcion'],
        'proyectos' => ['nombre', 'descripcion'],
        'referencias_familiares' => ['nombre', 'parentesco', 'ocupacion', 'celular'],
        'referencias_personales' => ['nombre', 'ocupacion', 'celular'],
    ];

    public const ESTADOS_CIVILES = [
        'soltero' => ['Soltero', 'Soltera'],
        'casado' => ['Casado', 'Casada'],
        'union_libre' => ['Unión libre', 'Unión libre'],
        'divorciado' => ['Divorciado', 'Divorciada'],
        'separado' => ['Separado', 'Separada'],
        'viudo' => ['Viudo', 'Viuda'],
    ];

    public const UNIDADES_DURACION = ['anios' => 'Años', 'meses' => 'Meses'];

    /** Diseños disponibles: vista PDF y nombre visible. */
    public const PLANTILLAS = [
        'clasica' => ['pdf/hoja_vida', 'Clásica'],
        'dos_columnas' => ['pdf/hoja_vida_dos_columnas', 'Dos columnas'],
    ];

    /** Columnas con valor por defecto: no cuentan para decidir si una fila tiene datos. */
    private const COLUMNAS_AUXILIARES = ['unidad'];

    /** Columnas de texto largo (descripciones) dentro de los grupos. */
    private const COLUMNAS_LARGAS = ['descripcion'];

    /**
     * Solo JPG: dompdf 3 necesita la extensión GD para incrustar cualquier PNG y su
     * disponibilidad varía entre servidores; las JPG se incrustan siempre, sin extensiones.
     */
    public const TIPOS_FOTO = ['image/jpeg'];

    private array $grupos = [];
    private ?string $foto = null;
    /** Error de la foto subida: se guarda aparte porque esValido() reinicia la lista de errores. */
    private ?string $errorFoto = null;

    public function __construct(array $datos = [], array $grupos = [])
    {
        parent::__construct($datos);
        foreach (array_keys(self::GRUPOS) as $grupo) {
            $this->grupos[$grupo] = $grupos[$grupo] ?? [];
            if ($this->grupos[$grupo] === []) {
                $this->agregarGrupo($grupo);
            }
        }
    }

    protected static function campos(): array
    {
        return [
            'nombre' => 0, 'genero' => 10, 'profesion' => 0, 'tipo_documento' => 5, 'documento' => 20,
            'fecha_nacimiento' => 10, 'estado_civil' => 15, 'direccion' => 0, 'barrio' => 0,
            'ciudad' => 80, 'celular' => 20, 'correo' => 0, 'expedicion' => 80,
            'enlace_profesional' => 0, 'sitio_web' => 0, 'plantilla' => 20, 'perfil_sugerido' => 1,
            'perfil' => (int) Config::obtener('limites.texto_largo'),
        ];
    }

    protected static function valoresIniciales(): array
    {
        return ['tipo_documento' => 'CC', 'plantilla' => 'clasica', 'perfil_sugerido' => '1'];
    }

    public static function desdeSolicitud(Solicitud $solicitud)
    {
        $base = parent::desdeSolicitud($solicitud);
        $limite = (int) Config::obtener('limites.texto');
        $limiteLargo = (int) Config::obtener('limites.texto_largo');
        $maximo = (int) Config::obtener('limites.grupos');
        $grupos = [];

        foreach (self::GRUPOS as $grupo => $columnas) {
            $enviado = $solicitud->arreglo($grupo);
            $filas = 0;
            foreach ($columnas as $columna) {
                $filas = max($filas, is_array($enviado[$columna] ?? null) ? count($enviado[$columna]) : 0);
            }
            $grupos[$grupo] = [];
            for ($i = 0; $i < min($filas, $maximo); $i++) {
                $fila = [];
                foreach ($columnas as $columna) {
                    $fila[$columna] = Solicitud::limpiar(
                        $enviado[$columna][$i] ?? '',
                        in_array($columna, self::COLUMNAS_LARGAS, true) ? $limiteLargo : $limite
                    );
                }
                $grupos[$grupo][] = $fila;
            }
        }
        return new self($base->datos, $grupos);
    }

    // --- Grupos repetibles ----------------------------------------------------------------

    /** Filas del grupo tal como se muestran en el formulario (incluye filas vacías). */
    public function grupo(string $grupo): array
    {
        return $this->grupos[$grupo] ?? [];
    }

    /**
     * Filas con al menos un dato escrito por el usuario, para el PDF. Las columnas auxiliares
     * (la unidad «años/meses» siempre trae un valor) no cuentan: una experiencia vacía no aparece.
     */
    public function grupoLleno(string $grupo): array
    {
        return array_values(array_filter($this->grupo($grupo), static function (array $fila): bool {
            return implode('', array_diff_key($fila, array_flip(self::COLUMNAS_AUXILIARES))) !== '';
        }));
    }

    public function agregarGrupo(string $grupo): void
    {
        if (!isset(self::GRUPOS[$grupo]) || count($this->grupos[$grupo]) >= (int) Config::obtener('limites.grupos')) {
            return;
        }
        $fila = array_fill_keys(self::GRUPOS[$grupo], '');
        if ($grupo === 'experiencia') {
            $fila['unidad'] = 'anios';
        }
        $this->grupos[$grupo][] = $fila;
    }

    public function quitarGrupo(string $grupo, int $indice): void
    {
        if (isset($this->grupos[$grupo][$indice]) && count($this->grupos[$grupo]) > 1) {
            array_splice($this->grupos[$grupo], $indice, 1);
        }
    }

    // --- Foto -----------------------------------------------------------------------------

    /** Valida la imagen subida y la conserva como data URI (dompdf la incrusta sin tocar disco). */
    public function adjuntarFoto(?array $archivo): void
    {
        if ($archivo === null || $archivo['error'] === UPLOAD_ERR_NO_FILE) {
            return;
        }
        if ($archivo['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($archivo['tmp_name'])) {
            $this->errorFoto = 'No se pudo recibir la foto. Intenta con una imagen más liviana.';
            return;
        }
        if ($archivo['size'] > (int) Config::obtener('limites.foto_bytes')) {
            $this->errorFoto = 'La foto debe pesar máximo 2 MB.';
            return;
        }
        $info = @getimagesize($archivo['tmp_name']);
        if ($info === false || !in_array($info['mime'], self::TIPOS_FOTO, true)) {
            $this->errorFoto = 'La foto debe estar en formato JPG. Si es PNG u otro formato, guárdala como JPG e inténtalo de nuevo.';
            return;
        }
        $this->foto = 'data:' . $info['mime'] . ';base64,' . base64_encode((string) file_get_contents($archivo['tmp_name']));
    }

    public function foto(): ?string
    {
        return $this->foto;
    }

    // --- Validación y presentación --------------------------------------------------------

    protected function validar(): void
    {
        if ($this->errorFoto !== null) {
            $this->agregarError('foto', $this->errorFoto);
        }
        $this->requerir('nombre', 'Escribe tu nombre completo.');
        $this->exigirOpcion('genero', Genero::opciones(), 'Elige cómo quieres que se redacte tu hoja de vida: hombre o mujer.');
        $this->exigirOpcion('tipo_documento', self::TIPOS_DOCUMENTO, 'Elige un tipo de documento.');
        $this->exigirNumeroDocumento('documento', 'El número de documento solo admite números, letras, puntos o guiones.', false);
        $this->exigirFecha('fecha_nacimiento', 'La fecha de nacimiento no es válida.', false);
        $nacimiento = Fecha::crear($this->valor('fecha_nacimiento'));
        if ($nacimiento && $nacimiento > new \DateTimeImmutable('today')) {
            $this->agregarError('fecha_nacimiento', 'La fecha de nacimiento no puede estar en el futuro.');
        }
        $this->exigirOpcion('estado_civil', self::ESTADOS_CIVILES, 'Elige un estado civil de la lista.', false);
        $this->exigirTelefono('celular', 'Escribe un celular válido (7 a 20 dígitos).');
        $this->exigirCorreo('correo', 'Escribe un correo electrónico válido.');
        $this->exigirOpcion('plantilla', self::PLANTILLAS, 'Elige el diseño de tu hoja de vida.');
        $this->exigirPatron('enlace_profesional', '/^\S+$/', 'Escribe el enlace sin espacios.', false);
        $this->exigirPatron('sitio_web', '/^\S+$/', 'Escribe el enlace sin espacios.', false);
    }

    public function genero(): Genero
    {
        return new Genero($this->valor('genero'));
    }

    /** Vista PDF según la plantilla elegida. */
    public function vistaPdf(): string
    {
        return (self::PLANTILLAS[$this->valor('plantilla')] ?? self::PLANTILLAS['clasica'])[0];
    }

    /** «CC 1111111111 de Rionegro»; vacío si no se escribió el número. */
    public function documentoCompleto(): string
    {
        if ($this->valor('documento') === '') {
            return '';
        }
        $texto = $this->valor('tipo_documento') . ' ' . $this->valor('documento');
        return $this->valor('expedicion') !== '' ? $texto . ' de ' . $this->valor('expedicion') : $texto;
    }

    /**
     * Perfil profesional: el escrito por el usuario o, si lo pidió, uno sugerido según su género.
     * Vacío cuando no hay texto y no se pidió la sugerencia: entonces la sección no se imprime.
     */
    public function perfil(): string
    {
        if ($this->valor('perfil') !== '') {
            return $this->valor('perfil');
        }
        if ($this->valor('perfil_sugerido') !== '1') {
            return '';
        }
        $g = $this->genero();
        return 'Soy una persona comprometida con la excelencia y la eficiencia en mi trabajo. Me considero '
            . $g->segun('proactivo', 'proactiva') . ', responsable y con gran capacidad de aprendizaje, siempre '
            . $g->segun('dispuesto', 'dispuesta') . ' a asumir nuevos retos. Me enfoco en resolver problemas de manera '
            . 'ágil y consistente y en colaborar de forma efectiva con mi equipo. Mi objetivo es contribuir al éxito de la '
            . 'organización y crecer profesionalmente en un entorno dinámico, manteniendo siempre una actitud positiva ante '
            . 'las tareas que se me encomienden.';
    }

    /** Enlaces profesionales escritos, sin «https://» para que se lean mejor impresos. */
    public function enlaces(): array
    {
        $enlaces = [];
        foreach (['enlace_profesional', 'sitio_web'] as $campo) {
            if ($this->valor($campo) !== '') {
                $enlaces[] = (string) preg_replace('#^https?://(www\.)?#i', '', rtrim($this->valor($campo), '/'));
            }
        }
        return $enlaces;
    }

    public function estadoCivil(): string
    {
        $formas = self::ESTADOS_CIVILES[$this->valor('estado_civil')] ?? null;
        return $formas === null ? '' : $this->genero()->segun($formas[0], $formas[1]);
    }

    /** «2 años», «1 año», «6 meses». */
    public static function duracion(string $cantidad, string $unidad): string
    {
        if (!ctype_digit($cantidad) || (int) $cantidad === 0) {
            return '';
        }
        $n = (int) $cantidad;
        if ($unidad === 'meses') {
            return $n . ($n === 1 ? ' mes' : ' meses');
        }
        return $n . ($n === 1 ? ' año' : ' años');
    }
}
