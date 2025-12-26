  <main class="contenedor seccion">
    <h1>Actualizar</h1>

    <?php foreach($errores as $error) :?>
      <div class="alerta error">
        <?php echo $error; ?>
      </div>
    <?php endforeach; ?>

    <a href="/listas" class="boton boton-amarillo">Volver</a>

    <form class="formulario" method="POST" enctype="multipart/form-data"> 
      <fieldset>
        <legend>Actualizar Lista</legend>

        <?php include 'formulario.php' ?>        

      <input type="submit" value="Actualizar Lista" class="boton boton-verde">
    </form>

  </main>
