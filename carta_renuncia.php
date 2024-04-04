<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="./recursos/estilos.css">
    <meta charset="UTF-8" />
    <title>carta de renuncia</title>
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
            <input type="text" name="ciudad" placeholder="ingresa la ciudad de redacción">
            <label>Fecha de redacción:</label>
            <input type="date" name="fecha">
            <label>Nombre de la empresa:</label>
            <input type="text" name="nombre_empresa" placeholder="ingresa el nombre de la empresa">
            <label>Nombre del jefe: </label>
            <input type="text" name="nombre_jefe" placeholder="ingresa el nombre del jefe">
            <label>Nombre completo de quien renuncia:</label>
            <input type="text" name="nombre_renunciante" placeholder="ingresa el nombre de quien renuncia">
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
            <input type="text" name="cedula_renunciante" placeholder="ingresa la cedula de quien renuncia">
            <label>Telefono de quien renuncia</label>
            <input type="text" name="telefono_renunciante" placeholder="ingresa el telefono de quien renuncia">
            <input type="submit" value="enviar">
        </form>

    </div>
</body>

</html>