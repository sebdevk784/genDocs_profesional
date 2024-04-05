<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8" />
    <title>carta recomendacion personal</title>
    <link rel="icon" type="image/png" href="./recursos/img/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./recursos/estilos.css">
</head>
<header>
    <?php
    include "./navbar_template.php";
    ?>
</header>

<body>
    <div class="formulario">
        <form method="POST" action="crear_carta_recomendacion_pdf.php">
            <h1>FORMULARIO CARTA DE RECOMENDACIÓN PERSONAL</h1>
            <label>Ciudad y Departamento:</label>
            <input type="text" name="ciudad" placeholder="Rionegro -Antioquia">
            <label>Fecha de redacción:</label>
            <input type="date" name="fecha">
            <label>Nombre del recomendado:</label>
            <input type="text" name="nombre_recomendado" placeholder="Sebastián Gonzalez Echavarría">
            <label>Documento del recomendado</label>
            <input type="number" name="documento_recomendado" placeholder="9999999999">
            <label>numero de años o meses de conocerse</label>
            <input type="number" name="tiempo_conocidos" placeholder="5">
            <label>meses/años de conocerse</label>
            <select name="unidad_tiempo_conocidos">
                <option value="año">Año</option>
                <option value="años" selected>Años</option>
                <option value="mes">Mes</option>
                <option value="meses">Meses</option>
            </select>
            <label>Nombre de quien recomienda</label>
            <input type="text" name="nombre_recomendador" placeholder="Raúl Martínez Gomez">
            <label>Numero de cédula del recomendador</label>
            <select name="tipo_documento">
                <option value="CC">Cédula de ciudadanía</option>
                <option value="PPT">Permiso por protección temporal</option>
                <option value="PEP">Permiso especial de permanencia</option>
                <option value="CE">Cédula de extrangería</option>
            </select>
            <label>Número de cédula de quien recomienda</label>
            <input type="number" name="cedula_recomendador" placeholder=" 88888888">
            <label>Telefono de quien recomienda</label>
            <input type="number" name="telefono_recomendador" placeholder="3333333333">
            <input type="submit" value="enviar">
        </form>
    </div>
</body>
<footer>
    <?php
    include './footer_template.php';
    ?>
</footer>

</html>