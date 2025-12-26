  <main class="contenedor seccion contenido-listaproductos">
    <p class="nombre-lista">Mantenimiento de Lista: <?php echo $nombreLista ?></p>
    
    <section class="listas">
        <?php foreach ($resultadoElegidos as $elegidos): ?>

          <?php if ($catInicial !== $elegidos->nombreCat): ?>

            <?php if ($catInicial !== null): ?>
                </div> <!-- cierro grid de la categoría anterior -->
              </div>   <!-- cierro bloque categoría -->
            <?php endif; ?>

            <?php $catInicial = $elegidos->nombreCat; ?>

            <div class="categoria">
              <p class="titCategoria"><?= s($catInicial); ?></p>
              <div class="elementos" id="bloque-elegidos">

          <?php endif; ?>

              <div class="articulo-elegido"
                data-lista="<?= $idLista ?>"
                data-articulo="<?= $elegidos->id; ?>"
              >
                <p class="titCategoria"><?= s($elegidos->nombre); ?></p>
              </div>

        <?php endforeach; ?>

        <?php if ($catInicial !== null): ?>
            </div> <!-- cierro último grid -->
          </div>   <!-- cierro última categoría -->
        <?php endif; ?>        

        <div class="elementos" id="bloque-disponibles">
          <?php foreach ( $resultadoDisponibles as $disponibles ): ?>            
            <div class="articulo-disponible" 
              data-lista="<?php echo $idLista ?>"
              data-articulo="<?php echo $disponibles->id;?>"
            >    
              <?php echo $disponibles->nombre;?>
            </div>
          <?php endforeach; ?>
        </div>

        <div id="bloque-categorias" class="busqueda-categorias">
          <?php foreach ( $resultadoCategorias as $cat ): ?>            
            <a href="/listas/listacatprod?idLista=<?php echo $idLista ?>&idCat=<?php echo $cat->id;?>">
              <div class="busqueda-categoria lista">    
                <?php echo $cat->nombre;?>&nbsp;&nbsp;&#8250;             
              </div>
            </a>
          <?php endforeach; ?>
        </div>

      <a href="/articulos/crear?backTipoLista=<?php echo $tipoLista ?>" class="boton boton-verde">Nuevo Articulo</a>    

      <form id="formMover" method="POST" action="/listas/moverelemento" style="display:none;">
        <input type="hidden" name="id_lista" id="id_lista">
        <input type="hidden" name="id_articulo" id="id_articulo">
        <input type="hidden" name="url_regreso" value="/listas/listaproductos?id=<?php echo $idLista ?>">  
        <input type="hidden" name="bloque_origen" id="bloque_origen">                                                             
        <input type="hidden" name="accion" id="accion">
      </form>
      
    </section>   
  </main>
