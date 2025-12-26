  <main class="contenedor seccion">
    <h1>Crear</h1>

    <?php foreach($errores as $error) :?>
      <div class="alerta error">
        <?php echo $error; ?>
      </div>
    <?php endforeach; ?>

    <a href="/listas" class="boton boton-amarillo">Volver</a>

    <form class="formulario" method="POST" action="/listas/crear" enctype="multipart/form-data">
      <fieldset>
        <legend>Nueva Lista</legend>

        <?php include 'formulario.php' ?>        

      <input type="submit" value="Crear Lista" class="boton boton-verde">
    </form>

  </main>