<main class="contenedor seccion contenido-main">
  <h1>Administrador de Listas</h1>

  <?php 
    $mensaje = mostrarNotificacion(intval($resultado));
    if ($mensaje) { 
  ?>
    <p class="alerta exito"><?php echo s($mensaje) ?></p>
  <?php
    }
  ?>

  <a href="/listas/crear" class="boton boton-verde">Nueva Lista</a>
  <section class="listas"> 
    <?php foreach($listas as $lista): ?> 
      <div class="lista tarjetas-listas" data-lista="<?php echo $lista->id ?>">

        <a href="/listas/listaproductos?id=<?php echo $lista->id; ?>" class="link-lista">
          <div class="izquierda">
            <p><?php echo $lista->nombre; ?></p> 
            <img src="imagenes/<?php echo $lista->imagen; ?>" alt="imagen-tabla" class="imagen-tabla"> 
            <span><?php echo $lista->k_articulos; ?> Productos</span>
          </div>
        </a>

        <div class="derecha">
          <form method="POST" class="w-100" action="/listas/eliminar"> 
            <input type="hidden" name="id" value="<?php echo $lista->id ?>"> 
            <input type="submit" class="boton-rojo-block" value="Eliminar"> 
          </form> 
          <a href="/listas/actualizar?id=<?php echo $lista->id ?>" class="boton-amarillo-block">Actualizar</a>
        </div>

      </div>
    <?php endforeach; ?>
  </section>
</main>
