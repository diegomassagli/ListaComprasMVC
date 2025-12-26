<?php

  namespace Controllers;
  use MVC\Router;
  use Model\Lista;
  use Intervention\Image\Drivers\Gd\Driver;
  use Intervention\Image\ImageManager as Image;

  class ListaController {

    public static function indexListas (Router $router) {
      $listas = Lista::allListas();
      $resultado = $_GET['resultado'] ?? null;

      $router->render('listas/indexListas', [
        'listas' => $listas,
        'resultado' => $resultado
      ]);
    }


    public static function listaproductos (Router $router) {
      $idLista = validarORedireccionar('/listas');
      
      $bloque = $_GET['bloque'] ?? '';
      $lista = Lista::find($idLista);
      $tipoLista = $lista->tipoLista;
      $nombreLista = $lista->nombre;
      $catInicial = null;
      $resultadoElegidos = Lista::allArticulosElegidos($idLista);
      $resultadoDisponibles = Lista::allArticulosDisponibles($idLista, $tipoLista);
      $resultadoCategorias = Lista::allCategoriasDeUnTipoLista($tipoLista);
      
      
      $router->render('listas/listaproductos', [
        'nombreLista' => $nombreLista,
        'resultadoElegidos' => $resultadoElegidos,
        'catInicial' => $catInicial,
        'resultadoDisponibles' => $resultadoDisponibles,  
        'resultadoCategorias' => $resultadoCategorias,
        'idLista' => $idLista,
        'tipoLista' => $tipoLista
      ]);
    }

    public static function crear (Router $router) {
      $lista  = new Lista();
      $errores = Lista::getErrores();    
      $tiposLista = include '../includes/config/tipoLista.php';     

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lista = new Lista($_POST['lista']);

        $img = ($_FILES['lista']['name']['imagen']);     
        if ($img !== '' ) {          
          $nombreImagen = "lista-" .md5( uniqid( rand(), true ) ) . $img;                  
        }
        IF($_FILES['lista']['tmp_name']['imagen']) {
          $manager = new Image(Driver::class);
          $imagen = $manager->read($_FILES['lista']['tmp_name']['imagen'])->cover(800, 600, 'center');
          $lista->setImagen($nombreImagen);
        }

        $errores = $lista->validar();
        if ( empty($errores) ) { 
          if ( !is_dir(CARPETA_IMAGENES) ) {
            mkdir(CARPETA_IMAGENES);
          }                 
          $imagen->save(CARPETA_IMAGENES . $nombreImagen);
          $lista->guardar();      
        }
      }
      $router->render('listas/crear', [
        'lista' => $lista,
        'errores' => $errores,
        'tiposLista' => $tiposLista
      ]);
    }


    public static function actualizar (Router $router) {
      $id = validarORedireccionar('/listas');
      $lista = Lista::find($id);
      $errores = Lista::getErrores();       
      $tiposLista = include '../includes/config/tipoLista.php';

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $args = $_POST['lista'];
        $lista->sincronizar($args);
        $errores = $lista->validar();

        $img = ($_FILES['lista']['name']['imagen']);     
        if ($img !== '' ) {          
          $nombreImagen = "lista-" .md5( uniqid( rand(), true ) ) . $img;                  
        }
        if ($_FILES['lista']['tmp_name']['imagen']) {
          $manager = new Image(Driver::class);
          $imagen = $manager->read($_FILES['lista']['tmp_name']['imagen'])->cover(800, 600, 'center');
          $lista->setImagen($nombreImagen);
        }

        if (empty( $errores )) {
          if ($_FILES['lista']['tmp_name']['imagen']) {
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
          }
          $lista->guardar();
        }  
      }
      $router->render('listas/actualizar', [
        'lista' => $lista,
        'errores' => $errores,
        'tiposLista' => $tiposLista
      ]);  
    }


    public static function eliminar() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int)$_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id) {
          $lista = Lista::find($id);
          $lista->eliminar();
        }
      }
    }


    public static function moverelemento() {
      $bloque = $_POST['bloque_origen'] ?? '';
      $idArticulo = $_POST['id_articulo'];
      $idLista = $_POST['id_lista'];
      $accion = $_POST['accion'];
      $url_regreso = $_POST['url_regreso'];

      if ($accion === 'agregar')  {
        Lista::insertListaArticulo($idLista, $idArticulo);    
        header("Location: $url_regreso&bloque=$bloque");    
        exit;
      }

      if ($accion === 'quitar')  {
        Lista::deleteListaArticulo($idLista, $idArticulo);    
        header("Location: $url_regreso&bloque=$bloque");    
        exit;
      }
    }


    public static function listacatprod(Router $router) {
      $idLista = $_GET['idLista'];
      $idLista = filter_var($idLista, FILTER_VALIDATE_INT);
      if(!$idLista) {
        header('Location: /listas/listaproductos');
        exit;
      }
      $idCat = $_GET['idCat'];
      $idCat = filter_var($idCat, FILTER_VALIDATE_INT);
      if(!$idCat) {
        header('Location: /listas/listaproductos');
        exit;
      }
      $lista = Lista::find($idLista); 
      $tipoLista = $lista->tipoLista;
      $nombreLista = $lista->nombre; 
      $resultadoDisponibles = Lista::allArticulosListaCategoria($idLista, $idCat);          

      $router->render('listas/listacatprod', [
        'lista' => $lista,
        'nombreLista' => $nombreLista,
        'tipoLista' => $tipoLista,
        'resultadoDisponibles' => $resultadoDisponibles,
        'idLista' => $idLista,
        'idCat' => $idCat
      ]);      
    } 

  }