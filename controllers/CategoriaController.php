<?php

namespace Controllers;

use MVC\Router;
use Model\Categoria;

class CategoriaController {

  public static function indexCategorias( Router $router ) {

    $tiposLista = include '../includes/config/tipoLista.php';
    $categorias = Categoria::all();
    $resultado = $_GET['resultado'] ?? null;

    $router->render('categorias/indexCategorias', [
      'categorias' => $categorias,
      'resultado' => $resultado,
      'tiposLista' => $tiposLista
    ]);
  }


  public static function crear( Router $router ) {
    $categoria = new Categoria();
    $errores = Categoria::getErrores();   
    $tiposLista = include '../includes/config/tipoLista.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {          
      $categoria = new Categoria($_POST['categoria']);      
      $errores = $categoria->validar();
      if (empty($errores)) {
        $resultado = $categoria->guardar();
        if ($resultado) {
          header('Location: /categorias?resultado=1');
          exit;
        }
      }      
    }
    $router->render('categorias/crear', [
      'categoria' => $categoria,
      'tiposLista' => $tiposLista,
      'errores' => $errores
    ]);
  }

  public static function eliminar() {   
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id = $_POST['id'];
      $id = filter_var($id, FILTER_VALIDATE_INT);
      if ($id) {
        $categoria = Categoria::find($id);       
        $categoria->eliminar();
      }
    }
  }


  public static function actualizar (Router $router) {
    $id = validarORedireccionar('/categorias');          
    $categoria = Categoria::find($id);
    $errores = Categoria::getErrores();          
    $tiposLista = include '../includes/config/tipoLista.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
      $args = $_POST['categoria'];
      $categoria->sincronizar($args);
      $errores = $categoria->validar();
      if ( empty($errores) ) {         
        $categoria->guardar();        
      }
    }

    $router->render('categorias/actualizar', [
      'categoria' => $categoria,
      'tiposLista' => $tiposLista,
      'errores' => $errores
    ]);

  }


}