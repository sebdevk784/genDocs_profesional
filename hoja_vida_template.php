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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./recursos/cv_template.css">
    <title>cv temp</title>
</head>

<body>
    <!-- informacion del perfil profesional -->
    <div class="perfil_profesional">

    </div>
    <!--datos personales -->
    <div class="datos_personales">

    </div>
    <!-- Formacion Academica -->
    <div class="formacion_academica">

    </div>

    <!-- experiencia laboral -->
    <div class="experiencia_laboral">

    </div>
    <!-- referencias familiares -->
    <div class="referencias_familiares">

    </div>
    <!-- referencias personales -->
    <div class="referencias_personales">

    </div>


</body>

</html>