<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8" />
    <title>carta de renuncia</title>
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

        <form method="POST" action="crear_carta_renuncia_pdf.php">
            <h1>FORMULARIO CARTA DE RENUNCIA</h1>
            <label>Ciudad y Departamento:</label>
            <input type="text" name="ciudad" placeholder="Rionegro -Antioquia">
            <label>Fecha de redacción:</label>
            <input type="date" name="fecha">
            <label>Nombre de la empresa:</label>
            <input type="text" name="nombre_empresa" placeholder="Empresa">
            <label>Nombre del jefe: </label>
            <input type="text" name="nombre_jefe" placeholder="Raúl Gómez Gómez">
            <label>Nombre completo de quien renuncia:</label>
            <input type="text" name="nombre_renunciante" placeholder="Sebastian Gonzalez Echavarria">
            <label>Fecha de renuncia:</label>
            <input type="date" name="fecha_renuncia">
            <label>Tipo de documento</label>
            <select name="tipo_documento">
                <option value="CC">Cédula de ciudadanía</option>
                <option value="PPT">Permiso por protección temporal</option>
                <option value="PEP">Permiso especial de permanencia</option>
                <option value="CE">Cédula de extrangería</option>
            </select>
            <label>Numero de cédula de quien renuncia</label>
            <input type="number" name="cedula_renunciante" placeholder="9999999999">
            <label>Telefono de quien renuncia</label>
            <input type="number" name="telefono_renunciante" placeholder="3333333333">
            <input type="submit" value="enviar">
        </form>

    </div>
</body>

</html>