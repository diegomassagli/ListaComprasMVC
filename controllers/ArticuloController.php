<?php

  namespace Controllers;
  use MVC\Router;
  use Model\Articulo;
  use Model\Categoria;
  use Intervention\Image\Drivers\Gd\Driver;
  use Intervention\Image\ImageManager as Image;


  class ArticuloController {

    public static function indexArticulos( Router $router ) {   // para utilizar la misma instancia de router que se creo en index.php
      $articulos = Articulo::allArticulosConCategorias();      
      $resultado = $_GET['resultado'] ?? null;

      $router->render('articulos/indexArticulos', [
        'articulos' => $articulos,
        'resultado' => $resultado
      ]);     
    }

    public static function crear( Router $router ) {
      $articulo = new Articulo();      
      $errores = Articulo::getErrores();   

      $backTipoLista = $_GET['backTipoLista'] ?? 0;
      $backTipoLista = filter_var($backTipoLista, FILTER_VALIDATE_INT);    
      if ($backTipoLista !== 0) {
        $categorias = Categoria::allCategoriasDeUnTipoLista($backTipoLista);      
      } else {
        $categorias = Categoria::all();
      }

      $soloUna = count($categorias) === 1;    

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $articulo = new Articulo($_POST['articulo']);

        $img = ($_FILES['articulo']['name']['imagen']);
        
        if ($img !== '' ) {          
          $nombreImagen = "art-" .md5( uniqid( rand(), true ) ) . $img;                  
          IF($_FILES['articulo']['name']['imagen']) {
            $manager = new Image(Driver::class);
            $imagen = $manager->read($_FILES['articulo']['tmp_name']['imagen'])->cover(800, 600, 'center');
            $articulo->setImagen($nombreImagen);
          }
        }

        $errores = $articulo->validar();         

        if ( empty($errores) ) { 
          if ($img !== '' ) {          
            if ( !is_dir(CARPETA_IMAGENES) ) {
              mkdir(CARPETA_IMAGENES);
            }                 
            $imagen->save( CARPETA_IMAGENES . $nombreImagen);
          }
          $articulo->guardar();        
        }        
      }

      $router->render('articulos/crear', [
        'articulo' => $articulo,
        'categorias' => $categorias,
        'errores' => $errores,
        'soloUna' => $soloUna
      ]);
    }



    public static function actualizar( Router $router ) {
      $id = validarORedireccionar('/articulos');
      $articulo = Articulo::find($id);      
      $categorias = Categoria::all();
      $errores = Articulo::getErrores();        
    
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $args = $_POST['articulo'];
        $articulo->sincronizar($args);
        $errores = $articulo->validar();
        
        
        $img = ($_FILES['articulo']['name']['imagen']);     
        if ($img !== '' ) {          
          $nombreImagen = "art-" .md5( uniqid( rand(), true ) ) . $img;                  
        }
        
        if ($_FILES['articulo']['tmp_name']['imagen']) {
          $manager = new Image(Driver::class);
          $imagen = $manager->read($_FILES['articulo']['tmp_name']['imagen'])->cover(800, 600, 'center');
          $articulo->setImagen($nombreImagen);
        }
        
        if (empty( $errores )) {
          if ($_FILES['articulo']['tmp_name']['imagen']) {
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
          }
          $articulo->guardar();
        }        
      }

      $router->render('articulos/actualizar', [
        'articulo' => $articulo,
        'categorias' => $categorias,
        'errores' => $errores
      ]);      
    }


    public static function eliminar () {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int)$_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id) {
          // 1. Borrar relaciones
          $articulo = Articulo::find($id);
          $articulo->eliminarArticulo();
        }
      }

    }



  }
    
