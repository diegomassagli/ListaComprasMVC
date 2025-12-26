<?php 
  // el Router, no pertenece especificamente al modelo MVC, sino que pertenece al "front Controller" o App Core, es un orquesta todo

  namespace MVC;
  
  class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
      $this->rutasGET[$url] = $fn;      
    }

    public function post($url, $fn) {
      $this->rutasPOST[$url] = $fn;      
    }

    public function comprobarRutas() {
      session_start();
      $auth = $_SESSION['login'] ??  null;

      // Arreglo de rutas protegidas
      $rutas_protegidas = ['/listas', '/listas/crear', '/listas/actualizar', '/listas/eliminar', '/categorias', '/categorias/crear', '/categorias/actualizar', '/categorias/eliminar', '/articulos', '/articulos/crear', '/articulos/actualizar', '/articulos/eliminar'];

      $urlActual = $_SERVER['PATH_INFO'] ?? '/';      
      $metodo = $_SERVER['REQUEST_METHOD'];
      if($metodo === 'GET') {
        $fn = $this->rutasGET[$urlActual] ?? null;      
      } else {      
        $fn = $this->rutasPOST[$urlActual] ?? null;      
      } 

      if (in_array($urlActual, $rutas_protegidas) && !$auth) {
        header('Location: /login');
      }

      // esto indicaria, que existe la url y tengo una fn asociada  y el call_user_func permite llamar a una fn con nombre dinamico        
      if($fn) {
        call_user_func($fn, $this);

      } else {
        echo "Pagina No Encontrada";
      }
    }

    // Muestra una vista
    public function render($view, $datos = [] ) {
      foreach ( $datos as $key => $value) {
        $$key = $value;                                     // esto crea una $variable con la clave que recibio y le pone el valor. osea $variable = valor
      }

      ob_start();                                           // iniciamos almacenamiento en memoria (de la vista)
      include __DIR__ . "/views/$view.php";
      $contenido = ob_get_clean();                          // guarda en contenido la vista y limpia
      include __DIR__ . "/views/layout.php";
    }

   
  }