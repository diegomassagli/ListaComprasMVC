  <main class="contenedor seccion contenido-listaproductos">
    <p class="nombre-lista">Lista: <?php echo $nombreLista ?></p>
    
    <section class="listas">
      <div class="elementos">
        <?php foreach ( $resultadoDisponibles as $disponibles ): ?>                      
          <div class="articulos <?php echo $disponibles->incluido ? 'elegido' : '';?>"             
            data-lista="<?php echo $idLista ?>"
            data-articulo="<?php echo $disponibles->idarticulo;?>"
            data-estado="<?php echo $disponibles->incluido;?>"
          >    
            <?php echo $disponibles->nombre;?>
          </div>
        <?php endforeach; ?>
      </div>
        
      <form id="formMover" method="POST" action="/listas/moverelemento" style="display:none;">
        <input type="hidden" name="id_lista" id="id_lista">
        <input type="hidden" name="id_articulo" id="id_articulo">
        <input type="hidden" name="accion" id="accion">
        <input type="hidden" name="url_regreso" value="/listas/listacatprod?idLista=<?php echo $idLista ?>&idCat=<?php echo $idCat ?>">                                                       
      </form>
        
    </section>   
    <a href="/listas/listaproductos?id=<?php echo $idLista ?>" class="boton boton-amarillo">Volver</a>    
    
    <a href="/articulos/crear?regreso=lista" class="boton boton-verde">Nuevo Articulo</a>    
  </main>
