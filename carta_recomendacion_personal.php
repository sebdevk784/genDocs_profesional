<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>carta recomendacion personal</title>
</head>
<header>
    <?php
    include "./navbar_template.php";
    ?>
</header>

<body>
    <div class="formulario">
        <form method="POST" action="crear_carta_recomendacion_pdf.php">
            <label>Ciudad y Departamento:</label>
            <input type="text" name="ciudad" placeholder="ingresa la ciudad de redacción">
            <label>Fecha de redacción:</label>
            <input type="date" name="fecha">
            <label>Nombre del recomendado:</label>
            <input type="text" name="nombre_recomendado" placeholder="ingresa el nombre del que estan recomendando">
            <label>Documento del recomendado</label>
            <input type="text" name="documento_recomendado" placeholder="ingresa el documento del recomendado">
            <label>numero de años o meses de conocerse</label>
            <input type="text" name="tiempo_conocidos" placeholder="ingrese el numero de tiempo que llevan de conocerse">
            <label>meses/años de conocerse</label>
            <select name="unidad_tiempo_conocidos">
                <option value="año">Año</option>
                <option value="años">Años</option>
                <option value="mes">Mes</option>
                <option value="meses">Meses</option>
            </select>
            <label>Nombre de quien recomienda</label>
            <input type="text" name="nombre_recomendador" placeholder="ingresa el nombre de quien recomienda">
            <label>Numero de cedula de quien recomienda</label>
            <input type="text" name="cedula_recomendador" placeholder="ingresa la cedula de quien recomienda">
            <label>Telefono de quien recomienda</label>
            <input type="text" name="telefono_recomendador" placeholder="ingresa el telefono de quien recomienda">
            <input type="submit" value="enviar">
        </form>
    </div>
</body>

</html>