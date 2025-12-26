<?php

namespace Controllers;
use MVC\Router;
use Model\Admin;

class LoginController {

  public static function login(Router $router) {
    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      
      $auth = new Admin($_POST);

      $errores = $auth->validar();

      if(empty($errores)) {
        // verificar si el usuario existe
        $resultado = $auth->existeUsuario();
        if(!$resultado) {          
          $errores = Admin::getErrores();
        } else {
          // verificar si coinicide el password
          $autenticado = $auth->comprobarPassword($resultado);
          if($autenticado) {
            // autenticar al usuario
            $auth->autenticar();
          } else {
            // Password incorrecto
            $errores = Admin::getErrores();
          }
        }
      }
    }

    $router->render('auth/login', [
      'errores' => $errores
    ]);
  }

  public static function logout() {
    session_start(); // accedo a la sesion actual
    $_SESSION = [];
    header('Location: /listas');
  }

  



}