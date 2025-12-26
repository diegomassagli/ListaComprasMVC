<?php

namespace Controllers;

use MVC\Router;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {



  public static function nosotros(Router $router) {
    $router->render('paginas/nosotros', [

    ]);
  }


  public static function contacto( Router $router) {
    $mensaje = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      
      $respuestas = $_POST['contacto'];

      // Crear una instancia de PHPMailer
      $mail = new PHPMailer();
      // Coinfigurar SMTP
      $mail->isSMTP();
      $mail->Host = 'sandbox.smtp.mailtrap.io';
      $mail->SMTPAuth = true;
      $mail->Username = 'f359bc67cf1c05';
      $mail->Password = '19ea906627223c';
      $mail->SMTPSecure = 'tls';
      $mail->Port = '2525';

      // Configurar el contenido del email
      $mail->setFrom('admin@listacompras.com');
      $mail->addAddress('admin@listacompras.colm');
      $mail->Subject ='Tienes un nuevo mensaje';
      $mail->isHTML(true);
      $mail->CharSet = 'UTF-8';


      
      $contenido  = '<html>';
      $contenido .= '<p>Tienes un nuevo mensaje</p>';

      // Enviar de forma condicional algunos campos
      if($respuestas['contacto'] === 'telefono') { // es telefono
        $contenido .= '<p>Elegio ser contactado por telefono: </p>';
        $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . ' </p>';
      } else { // es email
        $contenido .= '<p>Elegio ser contactado por email: </p>';
        $contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>';
      }
      // Definir el contenido
      $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . ' </p>';
      $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>';
      $contenido .= '<p>Compra/Venta: ' . $respuestas['opciones'] . ' </p>';
      $contenido .= '<p>Presupuesto: $' . $respuestas['presupuesto'] . ' </p>';
      $contenido .= '<p>Contacto: ' . $respuestas['contacto'] . ' </p><br>';
      $contenido .= '</html>';

      $mail->Body = $contenido;
      $mail->AltBody = 'Tienes un nuevo mensaje (texto sin HTML)';

      // Enviar el email
      if ( $mail->send() ) {
        $mensaje =  "Mensaje enviado correctamente";
      } else {
        $mensaje =  "El mensaje no se pudo enviar";
      }
    }

    $router->render('paginas/contacto', [
      'mensaje' => $mensaje
    ]);    
  }

  
  
}