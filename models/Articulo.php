<?php

namespace Model;

class Articulo extends ActiveRecord {

  protected static $tabla = 'articulos';
  protected static $columnasDB = ['id', 'nombre', 'descripcion', 'categorias_id', 'imagen'];

  public $id;
  public $nombre;
  public $descripcion;
  public $categorias_id;
  public $imagen;
  public $nombreCat;
  

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->descripcion = $args['descripcion'] ?? '';
    $this->categorias_id = $args['categorias_id'] ?? '';
    $this->imagen = $args['imagen'] ?? '';
  }

  public function validar() {
    if (!$this->nombre) {
      self::$errores[] = "Debes añadir un Nombre";
    }
    if (!$this->categorias_id) {
      self::$errores[] = "Debes elegir una categoria";
    }
    return self::$errores;
  }

}