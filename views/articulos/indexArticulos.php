
  <main class="contenedor seccion">
    <h1>Administrador de Articulos</h1>

    <?php 
      if ($resultado) {
        $mensaje = mostrarNotificacion(intval($resultado));
        if ($mensaje) { 
    ?>
          <p class="alerta exito"><?php echo s($mensaje) ?></p>
    <?php
        }
      }
    ?>
    <a href="/articulos/crear" class="boton boton-verde">Nuevo Articulo</a>    

    <table class="lista-articulos">
      <thead>
        <tr>
          <th>Id</th>
          <th>Nombre</th>
          <th>Descripcion</th>
          <th>Categoria</th>
          <th>Imagen</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($articulos as $articulo): ?>
            <tr>
              <td><?php echo $articulo->id; ?></td>
              <td><?php echo $articulo->nombre;?></td>
              <td><?php echo $articulo->descripcion;?></td>
              <td><?php echo $articulo->nombreCat; ?></td>
              <td>
                <?php echo $articulo->imagen 
                    ? '<img src="/imagenes/' . $articulo->imagen . '" class="imagen-tabla">' 
                    : ''; 
                ?>
              </td>
              <td class="acciones">
                <form method="POST" class="w-100" action="/articulos/eliminar">
                  <input type="hidden" name="id" value="<?php echo $articulo->id ?>">
                  <input type="submit" class="trash-submit" value="">
                </form >                
                <a href="/articulos/actualizar?id=<?php echo $articulo->id; ?>" class="btn-edit">
                  <img src="/build/img/pencil-square.svg" alt="Editar">
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
      </tbody>
    </table>

  </main>
