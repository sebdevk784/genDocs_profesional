/* GenDocs: mejoras progresivas. El sitio funciona completo sin este archivo (los botones son
   formularios que procesa PHP); con él, los cambios se aplican al instante y sin recargar:
   - Tema claro/oscuro y tamaño de letra: actualiza <html> y guarda las mismas cookies que PHP.
   - Grupos repetibles de la hoja de vida: agrega o quita filas sin enviar el formulario
     (así no se pierde la foto ya seleccionada).
   - Resumen de errores: recibe el foco al cargar para que los lectores de pantalla lo anuncien. */
(function () {
  "use strict";

  var raiz = document.documentElement;

  /* ---------- Preferencias de visualización ---------- */
  var ajustes = document.querySelector("[data-preferencias]");
  if (ajustes) {
    var base = raiz.getAttribute("data-base") || "/";
    var dias = parseInt(ajustes.getAttribute("data-dias"), 10) || 365;
    var minimo = parseInt(ajustes.getAttribute("data-fuente-min"), 10);
    var normal = parseInt(ajustes.getAttribute("data-fuente-normal"), 10);
    var maximo = parseInt(ajustes.getAttribute("data-fuente-max"), 10);
    var anuncio = ajustes.querySelector("[data-anuncio]");
    var botonMenos = ajustes.querySelector('[name="fuente"][value="menos"]');
    var botonMas = ajustes.querySelector('[name="fuente"][value="mas"]');
    var botonNormal = ajustes.querySelector('[name="fuente"][value="normal"]');

    var guardarCookie = function (nombre, valor) {
      document.cookie = nombre + "=" + encodeURIComponent(valor) + "; max-age=" + dias * 86400 +
        "; path=" + base + "; SameSite=Lax" + (location.protocol === "https:" ? "; Secure" : "");
    };
    var anunciar = function (texto) {
      if (anuncio) anuncio.textContent = texto;
    };

    var aplicarTema = function (tema) {
      raiz.setAttribute("data-theme", tema === "oscuro" ? "dark" : "light");
      guardarCookie(ajustes.getAttribute("data-cookie-tema"), tema);
      // El botón pulsado se oculta: el foco pasa al que ahora es visible.
      var visible = ajustes.querySelector(tema === "oscuro" ? ".tema-claro" : ".tema-oscuro");
      if (visible) visible.focus();
      anunciar(tema === "oscuro" ? "Modo oscuro activado" : "Modo claro activado");
    };

    var aplicarFuente = function (accion, boton) {
      var actual = parseInt(raiz.getAttribute("data-fuente"), 10) || normal;
      var nuevo = accion === "menos" ? actual - 1 : accion === "mas" ? actual + 1 : normal;
      nuevo = Math.max(minimo, Math.min(maximo, nuevo));
      raiz.setAttribute("data-fuente", String(nuevo));
      guardarCookie(ajustes.getAttribute("data-cookie-fuente"), nuevo);
      botonMenos.disabled = nuevo <= minimo;
      botonMas.disabled = nuevo >= maximo;
      if (boton.disabled) botonNormal.focus();
      anunciar("Tamaño de letra " + nuevo + " de " + maximo);
    };

    ajustes.addEventListener("submit", function (evento) {
      var boton = evento.submitter;
      if (!boton) return; // navegador sin SubmitEvent.submitter: envío normal al servidor
      evento.preventDefault();
      if (boton.name === "tema") aplicarTema(boton.value);
      if (boton.name === "fuente") aplicarFuente(boton.value, boton);
    });
  }

  /* ---------- Grupos repetibles (hoja de vida) ---------- */
  Array.prototype.forEach.call(document.querySelectorAll("[data-repetible]"), function (lista) {
    var seccion = lista.closest("section");
    var agregar = seccion.querySelector("[data-agregar]");
    var limite = parseInt(lista.getAttribute("data-maximo"), 10) || 10;
    var items = function () { return lista.querySelectorAll("[data-item]"); };

    var actualizar = function () {
      var todos = items();
      Array.prototype.forEach.call(todos, function (item, i) {
        Array.prototype.forEach.call(item.querySelectorAll("[data-numero]"), function (n) { n.textContent = i + 1; });
        item.querySelector("[data-quitar]").hidden = todos.length < 2;
      });
      agregar.hidden = todos.length >= limite;
    };

    agregar.addEventListener("click", function (evento) {
      evento.preventDefault();
      var todos = items();
      if (todos.length >= limite) return;
      var nuevo = todos[todos.length - 1].cloneNode(true);
      Array.prototype.forEach.call(nuevo.querySelectorAll("input, textarea"), function (campo) { campo.value = ""; });
      Array.prototype.forEach.call(nuevo.querySelectorAll("select"), function (campo) { campo.selectedIndex = 0; });
      lista.appendChild(nuevo);
      actualizar();
      var primero = nuevo.querySelector("input, select, textarea");
      if (primero) primero.focus();
    });

    lista.addEventListener("click", function (evento) {
      var boton = evento.target.closest("[data-quitar]");
      if (!boton) return;
      evento.preventDefault();
      var item = boton.closest("[data-item]");
      var vecino = item.previousElementSibling || item.nextElementSibling;
      item.parentNode.removeChild(item);
      actualizar();
      var foco = vecino && vecino.querySelector("input, select, textarea");
      (foco || agregar).focus();
    });
  });

  /* ---------- Resumen de errores ---------- */
  var resumen = document.getElementById("resumen-errores");
  if (resumen) {
    resumen.focus();
    // Los enlaces del resumen llevan el foco al primer control del campo (también en radios).
    resumen.addEventListener("click", function (evento) {
      var enlace = evento.target.closest("a[href^='#']");
      if (!enlace) return;
      var destino = document.getElementById(enlace.getAttribute("href").slice(1));
      if (!destino) return;
      var control = destino.matches("input, select, textarea") ? destino : destino.querySelector("input, select, textarea");
      if (control) {
        evento.preventDefault();
        control.focus();
        destino.scrollIntoView({ block: "center" });
      }
    });
  }
})();
