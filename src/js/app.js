
/* escucho que el documento se haya cargado, tanto html, como js como el css */ 

document.addEventListener('DOMContentLoaded', function() {
  eventListeners();
  const params = new URLSearchParams(window.location.search);
  const bloque = params.get("bloque");

  if (bloque === "elegidos") {
      document.getElementById("bloque-elegidos")?.scrollIntoView({ behavior: "smooth" });
  }
  if (bloque === "disponibles") {
      document.getElementById("bloque-disponibles")?.scrollIntoView({ behavior: "smooth" });
  }
  if (bloque === "categorias") {
      document.getElementById("bloque-categorias")?.scrollIntoView({ behavior: "smooth" });
  }
})

function eventListeners() {
  const mobileMenu = document.querySelector('.mobile-menu');
  mobileMenu.addEventListener('click', navegacionResponsive)

  document.querySelectorAll('.articulo-disponible').forEach( item => {
    item.addEventListener('click', (e) => moverArticulo(e, 'agregar'));
  })

  document.querySelectorAll('.articulo-elegido').forEach( item => {
    item.addEventListener('click', (e) => moverArticulo(e, 'quitar'));
  })

  document.querySelectorAll('.tarjetas-listas').forEach( item => {
    item.addEventListener('click', (e) => moverArticulo(e, 'quitar'));
  })

  document.querySelectorAll('.articulos').forEach( item => {
    item.addEventListener('click', (e) => moverArticulo(e, 'verestado'));
  })  

  // Muestra campos condicionales
  const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');  
  // el querySelectorAll devuelve un arreglo, NO puedo asignarle addEventListener al arreglo
  metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto)) // debo recorrerlo y hacerlo de a un elemento
}

function mostrarMetodosContacto(e) {
  const contactoDiv = document.querySelector('#contacto');
  if (e.target.value === 'telefono') {
    contactoDiv.innerHTML = `
      <label for="telefono">Telefono</label>
      <input type="tel" placelholder="Tu Telefono" name="contacto[telefono]">
    `;
  } else {
    contactoDiv.innerHTML = `
      <label form="email">Email</label>
      <input type="email" placelholder="Tu Email" id="Email" name="contacto[email]">
    `
  }
}


function navegacionResponsive() {
  const navegacion = document.querySelector('.navegacion');
  if (navegacion.classList.contains('mostrar')) {
    navegacion.classList.remove('mostrar');
  } else {
    navegacion.classList.add('mostrar');
  }
}


function moverArticulo(e, accion) {
  const item = e.currentTarget;
  const idArticulo = item.dataset.articulo;
  const idLista = item.dataset.lista;
  const estado = item.dataset.estado;
  if (accion === 'verestado') {
    if (estado === '0') {
      accion = 'agregar'
    } else {
      accion = 'quitar'
    }
  }
  if (item.classList.contains("articulo-elegido")) {
      document.getElementById('bloque_origen').value = "elegidos";
  } else if (item.classList.contains("articulo-disponible")) {
      document.getElementById('bloque_origen').value = "disponibles";
  }

  document.getElementById('id_lista').value = idLista;
  document.getElementById('id_articulo').value = idArticulo;
  document.getElementById('accion').value = accion;
    
  document.getElementById('formMover').submit();  
}

