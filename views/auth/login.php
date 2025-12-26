  <main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesion</h1>

    <?php foreach($errores as $error) : ?>
      <div class="alerta error">
        <?php echo $error; ?>
      </div>
    <?php endforeach; ?>
    <form method="POST" class="formulario" action="/login">
      <fieldset>
        <legend>Email y Password</legend>
        
        <label for="email">Email</label>
        <input type="email" placeholder="Tu Email" id="email" name="email">

        <label for="password">Pasword</label>
        <input type="password" placeholder="Tu Password" id="password" name="password">

      </fieldset>
      <input type="submit" value="Iniciar Sesion" class="boton-verde"/>
    </form>
  </main>
