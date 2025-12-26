<?php

  require_once __DIR__ . '/../includes/app.php';

  use MVC\Router;
  use Controllers\ArticuloController;
  use Controllers\CategoriaController;
  use Controllers\ListaController;
  use Controllers\LoginController;
  use Controllers\PaginasController;

  $router = new Router();

  // primero le paso donde se encuentra el metodo, y luego el nombre del metodo y como esta como static no requiero instanciarlo !
  // primero registra estas rutas
  $router->get('/articulos', [ ArticuloController::class, 'indexArticulos'] );  // esto devuelve el namespace ArticuloController::class
  $router->get('/articulos/crear',[ ArticuloController::class, 'crear']  );
  $router->post('/articulos/crear',[ ArticuloController::class, 'crear']  );
  $router->get('/articulos/actualizar',[ ArticuloController::class, 'actualizar']  );
  $router->post('/articulos/actualizar',[ ArticuloController::class, 'actualizar']  );
  $router->post('/articulos/eliminar',[ ArticuloController::class, 'eliminar']  );
  

  $router->get('/categorias', [ CategoriaController::class, 'indexCategorias'] );  // esto devuelve el namespace ArticuloController::class
  $router->get('/categorias/crear',[ CategoriaController::class, 'crear']  );
  $router->post('/categorias/crear',[ CategoriaController::class, 'crear']  );
  $router->get('/categorias/actualizar',[ CategoriaController::class, 'actualizar']  );
  $router->post('/categorias/actualizar',[ CategoriaController::class, 'actualizar']  );
  $router->post('/categorias/eliminar',[ CategoriaController::class, 'eliminar']  );


  $router->get('/listas', [ ListaController::class, 'indexListas'] );  // esto devuelve el namespace ArticuloController::class
  $router->get('/listas/crear',[ ListaController::class, 'crear']  );
  $router->get('/listas/listaproductos',[ ListaController::class, 'listaproductos']  );
  $router->post('/listas/moverelemento',[ ListaController::class, 'moverelemento']  );
  $router->get('/listas/listacatprod',[ ListaController::class, 'listacatprod']  );
  $router->post('/listas/crear',[ ListaController::class, 'crear']  );
  $router->get('/listas/actualizar',[ ListaController::class, 'actualizar']  );
  $router->post('/listas/actualizar',[ ListaController::class, 'actualizar']  );
  $router->post('/listas/eliminar',[ ListaController::class, 'eliminar']  );

  $router->get('/nosotros', [PaginasController::class, 'nosotros']);
  $router->get('/contacto', [PaginasController::class, 'contacto']);
  $router->post('/contacto', [PaginasController::class, 'contacto']);

  // Login y Autenticacion
  $router->get('/login', [LoginController::class, 'login']);  // para mostrar el formulario
  $router->post('/login', [LoginController::class, 'login']); // para enviar datos desde el formulario
  $router->get('/logout', [LoginController::class, 'logout']); // para cerrar sesion
    
  $router->comprobarRutas();
