<?php
//rescatar datos metodo post de carta_recomendacion_personal.php
$ciudad = $_POST['ciudad'];
$fecha = $_POST['fecha'];
$nombre_recomendado = $_POST['nombre_recomendado'];
$documento_recomendado = $_POST['documento_recomendado'];
$tiempo_conocidos = $_POST['tiempo_conocidos'];
$unidad_tiempo_conocidos = $_POST['unidad_tiempo_conocidos'];
$nombre_recomendador = $_POST['nombre_recomendador'];
$tipo_documento = $_POST['tipo_documento'];
$cedula_recomendador = $_POST['cedula_recomendador'];
$telefono_recomendador = $_POST['telefono_recomendador'];
//array para formatear la fecha
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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./recursos/cartas_template.css">
    <title>carta recomendacion tmp</title>
</head>

<body>
    <header>
        <h1>CARTA RECOMENDACION PERSONAL</h1>
    </header>
    <!--imprimir ciudad y fecha de redacción -->
    <div class="contenido">
        <h3><?php echo $ciudad . ", " . $fecha_redaccion_formateada ?></h3>
        <h4>A quien corresponda:</h4>
        <h5>Reciba un cordial y respetuoso saludo.</h5>
        <p class="cuerpo_carta">
            Mediante la presente, me permito recomendar a <?php echo $nombre_recomendado ?>, quien se identifica con
            documento N°. <?php echo $documento_recomendado ?>. He tenido el gusto de conocerlo durante los últimos <?php echo $tiempo_conocidos . " " . $unidad_tiempo_conocidos . ", " ?> y puedo afirmar que es una persona íntegra, responsable y trabajadora.
        </p>
        <p class="cuerpo_carta">
            Destaco su dignidad de confianza, así como su aptitud y capacidad para afrontar cualquier
            responsabilidad que se le encomiende. Además, puedo asegurar que es competente, eficaz y responsable.
        </p>
        <p class="cuerpo_carta">Por estos motivos, reafirmo mi postura de recomendarlo para cualquier tarea o función que considere usted necesaria.</p>
        <p class="cuerpo_carta">Muchas gracias por su atención.</p>
        <p class="atentamente">Atentamente,</p>
        <p class="firma">________________________________</p>
        <?php
        echo    "<p class='firma'>" . $nombre_recomendador . "</p>";
        echo  "<p class='firma'>" . $tipo_documento . ": " . $cedula_recomendador . "</p>";
        echo   "<p class='firma'>" . "TEL: " . $telefono_recomendador . "</p>";
        ?>
    </div>
</body>


</html>