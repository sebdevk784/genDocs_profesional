<?php
//datos personales
$nombre = $_POST['nombre'];
$documento_identidad = $_POST['documento_identidad'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$estado_civil = $_POST['estado_civil'];
$direccion = $_POST['direccion'];
$barrio = $_POST['barrio'];
$celular = $_POST['celular'];
$correo = $_POST['correo'];
//datos de formacion academica
$instituciones = $_POST['instituciones'];
$titulo_obtenido = $_POST['titulo_obtenido'];
$año_graduacion = $_POST['año_graduacion'];
//datos experiencia laboral
$nombre_empresa = $_POST['nombre_empresa'];
$cargo_ocupado = $_POST['cargo_ocupado'];
$nombre_jefe = $_POST['nombre_jefe'];
$telefono_empresa = $_POST['telefono_empresa'];
$numero_duracion_empresa = $_POST['numero_duracion_empresa'];
$unidad_duracion_empresa = $_POST['unidad_duracion_empresa'];
//datos referencias familiares
$nombre_referencia_familiar = $_POST['nombre_referencia_familiar'];
$parentesco_referencia_familiar = $_POST['parentesco_referencia_familiar'];
$ocupacion_refrencia_familiar = $_POST['ocupacion_referencia_familiar'];
$celular_referencia_familiar = $_POST['celular_referencia_familiar'];
//datos referencias personales
$nombre_referencia_personal = $_POST['nombre_referencia_personal'];
$ocupacion_referencia_personal = $_POST['ocupacion_referencia_personal'];
$celular_referencia_personal = $_POST['celular_referencia_personal'];
//array para formatear la fecha
$meses = array(
    'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
    'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
);
//para formatear instancio la clase DateTime y le paso la fecha que deseo formatear
$date_nacimiento = new DateTime($fecha_nacimiento);
//relaciona el numero del mes con la posicion del array y asigna el mes en español
$mes_redaccion_español = $meses[$date_nacimiento->format('n') - 1];
//termino de formatear el dia y el año.
$fecha_nacimiento_formateada = $date_nacimiento->format('d') . ' de ' . $mes_redaccion_español . ' de ' . $date_nacimiento->format('Y');

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./recursos/cv_template.css">
    <title>cv temp</title>
</head>

<body>
    <!-- información del perfil profesional -->
    <div class="perfil_profesional">
        <!-- NOMBRE TITULO -->
        <h1><?php echo $nombre ?></h1>
        <?php
        //IMAGEN 3*4
        //procesar imagen
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                // Obtener información sobre la imagen
                $nombreArchivo = $_FILES['foto']['name'];
                $tipoArchivo = $_FILES['foto']['type'];
                $rutaTemporal = $_FILES['foto']['tmp_name'];

                // Verifica si es una imagen válida 
                if (strpos($tipoArchivo, 'image') !== false) {
                    // Muestra la imagen en la página
                    echo "<img class='foto' src=\"data:$tipoArchivo;base64," . base64_encode(file_get_contents($rutaTemporal)) . "\">";
                } else {
                    echo "El archivo no es una imagen válida.";
                }
            } else {
                echo "<div class='no_foto'> </div>";
            }
        }
        ?>
        <h4>PERFIL PROFESIONAL</h4>
        <p>Soy una persona comprometida con la excelencia y la eficiencia en mi trabajo. Me considero proactivo/a
            y tengo una gran capacidad de aprendizaje. Mi enfoque se centra en resolver problemas de manera ágil y
            consistente, además de colaborar efectivamente en equipo. Mi objetivo es contribuir al éxito de la
            organización y crecer profesionalmente en un entorno dinámico, manteniendo siempre una actitud
            positiva para abordar cualquier tarea que se me encomiende</p>
    </div>
    <!--datos personales -->
    <div class="datos_personales">
        <h3>DATOS PERSONALES</h3>
        <p><?php if ($nombre != null) {
                echo 'NOMBRE: ' . $nombre;
            } ?></p>
        <p><?php if ($documento_identidad != null) {
                echo 'DOCUMENTO DE IDENTIDAD: ' . $documento_identidad;
            } ?></p>
        <p><?php if ($fecha_nacimiento != null) {
                echo 'FECHA DE NACIMIENTO: ' . $fecha_nacimiento_formateada;
            } ?></p>
        <p><?php if ($estado_civil != null) {
                echo 'ESTADO CIVIL: ' . $estado_civil;
            } ?></p>
        <p><?php if ($direccion != null) {
                echo 'DIRECCIÓN: ' . $direccion;
            } ?></p>
        <p><?php if ($barrio != null) {
                echo 'BARRIO: ' . $barrio;
            } ?></p>
        <p><?php if ($celular != null) {
                echo 'CELULAR: ' . $celular;
            } ?></p>
        <p><?php if ($correo != null) {
                echo 'CORREO: ' . $correo;
            } ?></p>
    </div>
    <!-- Formacion Academica -->
    <div class="formacion_academica">

        <?php
        //validar que alguno de los campos este lleno para colocar titulo
        if ((!empty($instituciones) && count(array_filter($instituciones)) > 0)
            || (!empty($titulo_obtenido) && count(array_filter($titulo_obtenido)) > 0)
            || (!empty($año_graduacion) && count(array_filter($año_graduacion)) > 0)
        ) {
            echo '<h3>FORMACION ACADEMICA</h3>';
        }
        //llenar los datos y validar que no sean nulos
        for ($i = 0; $i < count($instituciones); $i++) {
            echo '<p>' . $instituciones[$i] . '</p>';
            if ($titulo_obtenido[$i] != null) {
                echo '<p> TITULO OBTENIDO: ' . $titulo_obtenido[$i] . '</p>';
            }
            if ($año_graduacion[$i] != null) {
                echo '<p> AÑO: ' . $año_graduacion[$i] . '</p>';
            }
        }
        ?>
    </div>

    <!-- experiencia laboral -->
    <div class="experiencia_laboral">
        <?php
        //validar que alguno de los campos este lleno para poner el titulo
        if ((!empty($nombre_empresa) && count(array_filter($nombre_empresa)) > 0)
            || (!empty($cargo_ocupado) && count(array_filter($cargo_ocupado)) > 0)
            || (!empty($nombre_jefe) && count(array_filter($nombre_jefe)) > 0)
            || (!empty($telefono_empresa) && count(array_filter($telefono_empresa)) > 0)
            || (!empty($numero_duracion_empresa) && count(array_filter($numero_duracion_empresa)) > 0)
        ) {
            echo '<h3>EXPERIENCIA LABORAL</h3>';
        }
        //llenar los datos y validando que no sean nulos
        for ($i = 0; $i < count($nombre_empresa); $i++) {
            if ($nombre_empresa[$i] != null) {
                echo '<p> NOMBRE EMPRESA: ' . $nombre_empresa[$i] . '</p>';
            }
            if ($cargo_ocupado[$i] != null) {
                echo '<p> CARGO: ' . $cargo_ocupado[$i] . '</p>';
            }
            if ($nombre_jefe[$i] != null) {
                echo '<p> JEFE: ' . $nombre_jefe[$i] . '</p>';
            }
            if ($telefono_empresa[$i] != null) {
                echo '<p> TELEFONO: ' . $telefono_empresa[$i] . '</p>';
            }
            if (($numero_duracion_empresa[$i] != null) && ($unidad_duracion_empresa[$i] != null)) {
                echo '<p> DURACION: ' . $numero_duracion_empresa[$i] . ' ' . $unidad_duracion_empresa[$i] . '</p>';
            }
        }
        ?>

    </div>
    <!-- referencias familiares -->
    <div class="referencias_familiares">
        <?php
        //validar que alguno de los camos este lleno para poner el titulo
        if ((!empty($nombre_referencia_familiar) && count(array_filter($nombre_referencia_familiar)) > 0)
            || (!empty($parentesco_referencia_familiar) && count(array_filter($parentesco_referencia_familiar)) > 0)
            || (!empty($ocupacion_refrencia_familiar) && count(array_filter($ocupacion_refrencia_familiar)) > 0)
            || (!empty($celular_referencia_familiar) && count(array_filter($celular_referencia_familiar)) > 0)
        ) {
            echo '<h3>REFERENCIAS FAMILIARES</h3>';
        }
        //llenar los datos y validar que no sean nulos
        for ($i = 0; $i < count($nombre_referencia_familiar); $i++) {
            if ($nombre_referencia_familiar[$i] != null) {
                echo '<p> NOMBRE: ' . $nombre_referencia_familiar[$i] . '</p>';
            }
            if ($parentesco_referencia_familiar[$i] != null) {
                echo '<p> PARENTESCO: ' . $parentesco_referencia_familiar[$i] . '</p>';
            }
            if ($ocupacion_refrencia_familiar[$i] != null) {
                echo '<p> OCUPACION: ' . $ocupacion_refrencia_familiar[$i] . '</p>';
            }
            if ($celular_referencia_familiar[$i] != null) {
                echo '<p> CELULAR: ' . $celular_referencia_familiar[$i] . '</p>';
            }
        }
        ?>
    </div>
    <!-- referencias personales -->
    <div class="referencias_personales">
        <?php
        if ((!empty($nombre_referencia_personal) && count(array_filter($nombre_referencia_personal)) > 0)
            || (!empty($ocupacion_referencia_personal) && count(array_filter($ocupacion_referencia_personal)) > 0)
            || (!empty($celular_referencia_personal) && count(array_filter($celular_referencia_personal)) > 0)
        ) {
            echo '<h3>REFERENCIAS PERSONAL</h3>';
        }
        //llenar los datos y validar que no sean nulos
        for ($i = 0; $i < count($nombre_referencia_personal); $i++) {
            if ($nombre_referencia_personal[$i] != null) {
                echo '<p> NOMBRE: ' . $nombre_referencia_personal[$i] . '</p>';
            }
            if ($ocupacion_referencia_personal[$i] != null) {
                echo '<p> OCUPACION: ' . $ocupacion_referencia_personal[$i] . '</p>';
            }
            if ($celular_referencia_personal[$i] != null) {
                echo '<p> CELULAR: ' . $celular_referencia_personal[$i] . '</p>';
            }
        }
        ?>
    </div>


</body>

</html>