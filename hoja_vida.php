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
  <!--Scrip para el formulario
  la funcion agregar_referencias sirve para añadir mas divs en caso de que el usuario desee agregar mas referencias.
  recibe el parametro idContenedor, es decir, el contenedor que se duplicará en caso de ser requerido

  la funcion eliminar referencias sirve para eliminar un contenedor creado por la funcion anterior, manteniendo el 
  contenedor original
  recibe como parametro idContenedor, es decir, el contenedor que se deberá eliminar en caso de ser requerido
-->
  <script>
    //crear campo de referencia
    function agregar_referencias(idContenedor) {
      var contenedor = document.getElementById(idContenedor);
      //clonar los campos de referencia
      var ultimos_inputs_contenedor = contenedor.lastElementChild;
      var clon_contenedor = ultimos_inputs_contenedor.cloneNode(true);
      //limpiar valor de los inputs clonados
      var inputs_contenedor = clon_contenedor.getElementsByTagName('input');
      for (var i = 0; i < inputs_contenedor.length; i++) {
        inputs_contenedor[i].value = '';
      }

      //añadir el clon
      contenedor.appendChild(clon_contenedor);

    }
    //funcion para eliminar divs
    function eliminar_referencias(idContenedor) {
      var contenedor = document.getElementById(idContenedor);
      if (contenedor.children.length > 1) {
        contenedor.removeChild(contenedor.lastElementChild);
      }
    }
  </script>
  <div class="formulario">
    <form action="crear_cv_pdf.php" method="POST" enctype="multipart/form-data">
      <h1>FORMULARIO HOJA DE VIDA</h1>
      <!--seccion datos personales -->
      <h2>DATOS PERSONALES.</h2><br>
      <label>Nombre:</label>
      <input type="text" name="nombre" placeholder="ingresa nombre completo">
      <label>Foto:</label>
      <input type="file" name="foto">
      <label>Documento de identidad:</label>
      <input type="text" name="documento_identidad" placeholder="ingresa solo el numero de documento">
      <label>Fecha de nacimiento:</label>
      <input type="date" name="fecha_nacimiento">
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
      <div id="formacion_academica">
        <h2>FORMACION ACADEMICA.</h2><br>
        <div id="grupo_formacion_academica" class="div_grupo_auxiliar">

          <label>Nombre de la institución:</label>
          <input type="text" name="instituciones[]">
          <label>Titulo obtenido:</label>
          <input type="text" name="titulo_obtenido[]" placeholder="primaria/secundaria/otro">
          <label>Año:</label>
          <input type="text" name="año_graduacion[]" placeholder="ingresa el año de graduación">
        </div>
      </div>
      <button type="button" onclick="agregar_referencias('formacion_academica')">agregar formación acádemica</button>
      <button type="button" onclick="eliminar_referencias('formacion_academica')">eliminar formación acádemica</button>
      <!--seccion experiencia laboral -->
      <div id="experiencia_laboral">
        <h2>EXPERIENCIA LABORAL.</h2>
        <div id="grupo_experiencia_laboral" class="div_grupo_auxiliar">

          <label>Nombre de la empresa:</label>
          <input type="text" name="nombre_empresa[]">
          <label>Cargo ocupado:</label>
          <input type="text" name="cargo_ocupado[]">
          <label>Nombre del jefe:</label>
          <input type="text" name="nombre_jefe[]">
          <label>Telefono:</label>
          <input type="text" name="telefono_empresa[]" placeholder="numero del telefono de la empresa">
          <label>Duración en la empresa:</label>
          <input type="text" name="numero_duracion_empresa[]">
          <select name="unidad_duracion_empresa[]">
            <option value="año">Año</option>
            <option value="años" selected>Años</option>
            <option value="mes">Mes</option>
            <option value="meses">Meses</option>
          </select>
        </div>
      </div>
      <button type="button" onclick="agregar_referencias('experiencia_laboral')">agregar experiencia</button>
      <button type="button" onclick="eliminar_referencias('experiencia_laboral')">eliminar experiencia</button>
      <!--seccion referencias familiares -->
      <div id="referencias_familiares">
        <h2>REFERENCIAS FAMILIARES.</h2>
        <div id="grupo_referencia_familiar" class="div_grupo_auxiliar">
          <label>Nombre de la referencia:</label>
          <input type="text" name="nombre_referencia_familiar[]">
          <label>Parentesco de la referencia:</label>
          <input type="text" name="parentesco_referencia_familiar[]" placeholder="mamá/papá/hermano/tío/etc.">
          <label>Ocupacion de la referencia:</label>
          <input type="text" name="ocupacion_referencia_familiar[]">
          <label>Celular de la referencia:</label>
          <input type="text" name="celular_referencia_familiar[]">
        </div>
      </div>
      <button type="button" onclick="agregar_referencias('referencias_familiares')">agregar referencia familiar</button>
      <button type="button" onclick="eliminar_referencias('referencias_familiares')">eliminar referencia familiar</button>
      <!--seccion referencias personales -->
      <div id="referencias_personales">
        <h2>REFERENCIAS PERSONALES.</h2>
        <div id="grupo_referencia_personal" class="div_grupo_auxiliar">

          <label>Nombre de la referencia:</label>
          <input type="text" name="nombre_referencia_personal[]">
          <label>Ocupacion de la referencia:</label>
          <input type="text" name="ocupacion_referencia_personal[]">
          <label>Celular de la referencia:</label>
          <input type="text" name="celular_referencia_personal[]">
        </div>
      </div>
      <button type="button" onclick="agregar_referencias('referencias_personales')">agregar referencia personal</button>
      <button type="button" onclick="eliminar_referencias('referencias_personales')">eliminar referencia personal</button>
      <!--enviar formulario -->
      <input type="submit" value="enviar">
    </form>
  </div>
</body>

</html>