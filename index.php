<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./recursos/img/logo.png">
    <link rel="stylesheet" href="./recursos/index_estilos.css">
    <title>GenDocs Profesional</title>
</head>
<header>
    <?php
    include "./navbar_template.php";
    ?>
</header>

<body>
    <div class="contenido">
        <div class="descripcion">
            <h1>Generador de documentos profesionales</h1>
            <p>Bienvenido a nuestro sitio web de generación automática de documentos profesionales.
                ¿Necesitas redactar una carta de renuncia, una hoja de vida o una carta de recomendación personal?
                ¡Estás en el lugar correcto! Nuestra plataforma te permite crear estos documentos de manera rápida y
                sencilla. Simplemente completa el formulario correspondiente, seleccionando el tipo de documento
                que necesitas y, en cuestión de segundos, recibirás un archivo en formato PDF listo para descargar.
                No más estrés ni complicaciones al redactar documentos importantes para tu carrera.
                ¡Comienza ahora y simplifica tu proceso de búsqueda de empleo o transición laboral! </p>
        </div>
        <div class="demostracion">
            <div class="demo">
                <h2>CARTA DE RENUNCIA</h2>
                <img src="./recursos/img/carta_recomendacion_demo.jpeg" alt="demo carta de renuncia">
                <p>Los datos proporcionados aquí son ficticios, y su único propósito es mostrar el formato
                    utilizado por nuestro sitio web. Cualquier parecido es pura coincidencia.</p>
                <p><a href="./carta_renuncia.php">Click aquí</a> para redactar tu carta de renuncia.</p>
            </div>
            <div class="demo">
                <h2>CARTA DE RECOMENDACION</h2>
                <img src="./recursos/img/carta_recomendacion_demo.jpeg" alt="demo carta de recomendación personal">
                <p>Los datos proporcionados aquí son ficticios, y su único propósito es mostrar el formato
                    utilizado por nuestro sitio web. Cualquier parecido es pura coincidencia.</p>
                <p><a href="./carta_recomendacion_personal.php">Click aquí</a> para redactar tu carta de recomendación personal.</p>
            </div>
            <div class="demo">
                <h2>HOJA DE VIDA</h2>
                <img src="./recursos/img/hoja_vida_1_demo.jpeg" alt="demo hoja de vida página 1">
                <img src="./recursos/img/hoja_vida_2_demo.jpeg" alt="demo hoja de vida página 2">
                <img src="./recursos/img/hoja_vida_3_demo.jpeg" alt="demo hoja de vida página 3">
                <p>Los datos proporcionados aquí son ficticios, y su único propósito es mostrar el formato
                    utilizado por nuestro sitio web. Cualquier parecido es pura coincidencia.</p>
                <p><a href="./hoja_vida.php">Click aquí</a> para realizar tu hoja de vida</p>
            </div>
        </div>
    </div>
</body>
<footer>
    <?php
    include './footer_template.php';
    ?>
</footer>

</html>