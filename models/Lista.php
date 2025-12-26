<?php
namespace Model;

class Lista extends ActiveRecord {

  protected static $tabla = 'listas';
  protected static $columnasDB = [ 'id', 'nombre', 'tipoLista', 'fechaCreacion', 'imagen', 'descripcion'];

  public $id;
  public $nombre;
  public $tipoLista;
  public $fechaCreacion;
  public $imagen;
  public $descripcion;
  public $k_articulos;
  public $incluido;
  public $idarticulo;
  public $nombreCat;


  public function __construct( $args = []) 
  {
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->tipoLista = $args['tipoLista'] ?? '';
    $this->fechaCreacion = $args['fechaCreacion'] ??  date('Y/m/d');
    $this->imagen = $args['imagen'] ?? '';
    $this->descripcion = $args['descripcion'] ?? '';
  }

  public function validar() {
    if (!$this->nombre) {
      self::$errores[] = "Debes añadir un Nombre";
    }
    if (!$this->tipoLista) {
      self::$errores[] = "Debes seleccionar un Tipo de Lista";
    }
    if (!$this->imagen) {
      self::$errores[] = "Debes seleccionar una imagen";
    }
    return self::$errores;
  }
  
}