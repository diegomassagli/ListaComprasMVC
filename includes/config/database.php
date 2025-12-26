
<?php

  function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', 'root', 'listacompras');

    if ($db->connect_errno) {
      echo 'Error de conexion: ' . $db->connect_errno;
      exit;
    } 
    return $db;    
  }
  