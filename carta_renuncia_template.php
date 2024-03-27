<?php
//rescatar datos del formulario mediante metodo post
$ciudad = $_POST['ciudad'];
//hace referencia a la fecha de redaccion
$fecha = $_POST['fecha'];
$nombre_empresa = $_POST['nombre_empresa'];
$nombre_jefe = $_POST['nombre_jefe'];
$nombre_renunciante = $_POST['nombre_renunciante'];
$fecha_renuncia = $_POST['fecha_renuncia'];
$cedula_renunciante = $_POST['cedula_renunciante'];
$telefono_renunciante = $_POST['telefono_renunciante'];
//array de meses para formatear la fecha
$meses = array(
    'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
    'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
);
//para formatear instancio la clase DateTime y le paso la fecha que deseo formatear
$date_redaccion = new DateTime($fecha);
//relaciona el numero del mes con la posicion del array y asigna el mes en español
$mes_redaccion_español = $meses[$date_redaccion->format('n') - 1];
//termino de formatear el dia y el año.
$fecha_redaccion_formateada = $date_redaccion->format('d') . ' de ' . $mes_redaccion_español . ' de ' . $date_redaccion->format('Y');

//formateo fecha de renuncia, instancio clase DateTime y le paso de parametro la fecha de renuncia
$date_renuncia = new DateTime($fecha_renuncia);
//relacionar mes original con el mes en español
$mes_renuncia_español = $meses[$date_renuncia->format('n') - 1];
//termino de formatear
$fecha_renuncia_formateada = $date_renuncia->format('d') . ' de ' . $mes_renuncia_español . ' de ' . $date_renuncia->format('Y');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./recursos/cartas_template.css">
    <title>Carta renuncia tmp</title>
</head>

<body>
    <header>
        <h1>CARTA DE RENUNCIA</h1>
    </header>
    <div class="contenido">
        <!--se imprime la ciudad y la fecha de redaccion -->
        <h3><?php echo $ciudad . ", " . $fecha_redaccion_formateada ?></h3>
        <h4><?php if ($nombre_empresa != null) {
                echo  "Señores(as): " . $nombre_empresa;
            } ?></h4>
        <h4>Asunto: carta de renuncia</h4>
        <h4>
            <?php if ($nombre_jefe != null) {
                echo  "Estimado(a): " . $nombre_jefe;
            } ?>
        </h4>
        <h5>Cordial saludo.</h5>
        <p class="cuerpo_carta">Sirva la presente para manifestar ante usted la renuncia al cargo que ocupo actualmente en la empresa.
            <?php if ($fecha_renuncia != null) {
                echo 'Donde desempeñaré mis funciones hasta el ' . $fecha_renuncia_formateada . '.';
            } ?>
        </p>
        <p class="cuerpo_carta">Agradezco todas las oportunidades de crecimiento personal y preparación profesional que se me brindaron
            durante el tiempo laborado, aprendizajes que me permitieron consolidar mi perfil técnico y humano;
            pero motivos personales me llevan a tomar esta difícil decisión, que espero sea tomada de la mejor manera
            por la dirección de esta empresa. </p>
        <p class="cuerpo_carta">Sin más a que hacer referencia, y en espera de su comprensión y mayor consideración.</p>
        <p class="atentamente">Atentamente, </p>

        <p class="firma">________________________________</p>
        <?php
        echo    "<p class='firma'>" . $nombre_renunciante . "</p>";
        echo   "<p class='firma'>" . "DNI N° " . $cedula_renunciante . "</p>";
        echo  "<p class='firma'>" . "TEL: " . $telefono_renunciante . "</p>";
        ?>
    </div>
</body>

</html>