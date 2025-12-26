  <main class="contenedor seccion">
    <h1>Administrador de Categorias</h1>

    <?php 
      $mensaje = mostrarNotificacion(intval($resultado));
      if ($mensaje) { 
    ?>
      <p class="alerta exito"><?php echo s($mensaje) ?></p>
    <?php
      }
    ?>

    <a href="/categorias/crear" class="boton boton-verde">Nueva categoria</a>    

    <table class="categoria">
      <thead>
        <tr>
          <th>Id</th>
          <th>Nombre</th>
          <th>TipoLista</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($categorias as $categoria): ?>
            <?php $tipo = $categoria->tipoLista ?>
            <tr>
              <td><?php echo $categoria->id; ?></td>
              <td><?php echo $categoria->nombre;?></td>
              <td><?php echo $tiposLista[$tipo]; ?></td>
              <td>
                <form method="POST" class="w-100" action="/categorias/eliminar">
                  <input type="hidden" name="id" value="<?php echo $categoria->id ?>">
                  <input type="submit" class="boton-rojo-block" value="Eliminar">
                </form >
                <a href="/categorias/actualizar?id=<?php echo $categoria->id ?>" class="boton-amarillo-block">Actualizar</a>
              </td>
            </tr>
          <?php endforeach; ?>
      </tbody>
    </table>

  </main>
