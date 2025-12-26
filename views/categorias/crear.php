  <main class="contenedor seccion">
    <h1>Crear</h1>

    <?php foreach($errores as $error) :?>
      <div class="alerta error">
        <?php echo $error; ?>
      </div>
    <?php endforeach; ?>

    <a href="/categorias" class="boton boton-amarillo">Volver</a>

    <form class="formulario" method="POST" action="/categorias/crear">
      <?php include 'formulario.php' ?>
      <input type="submit" value="Crear Categoria" class="boton boton-verde">
    </form>

  </main>