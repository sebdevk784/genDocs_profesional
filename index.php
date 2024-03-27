<!DOCTYPE html>
<html lang="es">

<head>
  <link rel="stylesheet" href="./recursos/estilos.css">
  <meta charset="UTF-8" />
  <title>hoja de vida</title>
</head>
<header>
  <?php
  include "./navbar_template.php";
  ?>
</header>

<body>
  <!--Scrip para el formulario -->
  <script>
    //crear campo de referencia
    function agregar_referencia_familiar() {
      var div_referencia_familiar = document.getElementById('referencias_familiares');
      //clonar los campos de referencia
      var ultimos_inputs_referencia = div_referencia_familiar.lastElementChild;
      var clon_referencia_familiar = ultimos_inputs_referencia.cloneNode(true);
      //limpiar valor de los inputs clonados
      var inputs_referencia_familiar = clon_referencia_familiar.getElementsByTagName('input');
      for (var i = 0; i < inputs_referencia_familiar.length; i++) {
        inputs_referencia_familiar.value = '';
      }

      //añadir el clon
      div_referencia_familiar.appendChild(clon_referencia_familiar);

    }
    //funcion para eliminar divs
    function eliminar_referencia_familiar() {
      var div_referencia_familiar = document.getElementById('referencias_familiares');
      if (div_referencia_familiar.children.length > 1) {
        div_referencia_familiar.removeChild(div_referencia_familiar.lastElementChild);
      }
    }
  </script>
  <div class="formulario">
    <form>
      <!--seccion datos personales -->
      <label>DATOS PERSONALES.</label><br>
      <label>Nombre:</label>
      <input type="text" name="nombre" placeholder="ingresa nombre completo">
      <label>Documento de identidad:</label>
      <input type="text" name="documento_identidad" placeholder="ingresa solo el numero de documento">
      <label>Fecha de nacimiento:</label>
      <input type="date" name="fecha">
      <label>Estado civil:</label>
      <input type="text" name="estado_civil" placeholder="soltero/casado/viudo/etc">
      <label>Dirección:</label>
      <input type="text" name="direccion" placeholder="solo direccion y numero">
      <label>Barrio:</label>
      <input type="text" name="barrio" placeholder="solo el nombre del barrio">
      <label>Celular:</label>
      <input type="text" name="celular">
      <label>Correo:</label>
      <input type="text" name="correo" placeholder="ingresa el correo personal">
      <!--seccion formacion academica -->
      <label>FORMACION ACADEMICA.</label><br>
      <label>Nombre de la institución:</label>
      <input type="text" name="institucion">
      <label>Titulo obtenido:</label>
      <input type="text" name="titulo_obtenido" placeholder="primaria/secundaria/otro">
      <label>Año:</label>
      <input type="text" name="año_graduacion" placeholder="ingresa el año de graduación">
      <!--seccion experiencia laboral -->
      <label>EXPERIENCIA LABORAL.</label><br>
      <label>Nombre de la empresa:</label>
      <input type="text" name="nombre_empresa">
      <label>Cargo ocupado:</label>
      <input type="text" name="cargo_ocupado">
      <label>Nombre del jefe:</label>
      <input type="text" name="nombre_jefe">
      <label>Telefono:</label>
      <input type="text" name="telefono_empresa" placeholder="numero del telefono de la empresa">
      <label>Duración en la empresa:</label>
      <input type="text" name="numero_duracion_empresa ">
      <select name="unidad_duracion_empresa">
        <option value="año">Año</option>
        <option value="años">Años</option>
        <option value="mes">Mes</option>
        <option value="meses">Meses</option>
      </select>
      <!--seccion referencias familiares -->
      <div id="referencias_familiares" class="referencias_familiares">
        <div id="grupo_referencia_familiar" class="grupo_referencia_familiar">
          <label>REFERENCIAS FAMILIARES.</label><br>
          <label>Nombre de la referencia:</label>
          <input type="text" name="nombre_referencia">
          <label>Parentesco de la referencia:</label>
          <input type="text" name="parentesco_referencia" placeholder="mamá/papá/hermano/tío/etc.">
          <label>Ocupacion de la referencia:</label>
          <input type="text" name="ocupacion_referencia">
          <label>Celular de la referencia:</label>
          <input type="text" name="celular_referencia">
        </div>
      </div>
      <button type="button" onclick="agregar_referencia_familiar()">agregar referencia</button>
      <button type="button" onclick="eliminar_referencia_familiar()">eliminar referencia</button>
      <!--seccion referencias personales -->
      <label>REFERENCIAS PERSONAL.</label><br>
      <label>Nombre de la referencia:</label>
      <input type="text" name="nombre_referencia_personal">
      <label>Ocupacion de la referencia:</label>
      <input type="text" name="ocupacion_referencia_personal">
      <label>Celular de la referencia:</label>
      <input type="text" name="celular_referencia_personal">
      <!--enviar formulario -->
      <input type="submit" value="enviar">

    </form>
  </div>
</body>

</html>