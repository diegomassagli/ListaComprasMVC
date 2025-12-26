<?php
namespace Model;

class Categoria extends ActiveRecord {

  protected static $tabla = 'categorias';
  protected static $columnasDB = ['id', 'nombre', 'tipoLista'];

  public $id;
  public $nombre;
  public $tipoLista;


  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->tipoLista = $args['tipoLista'] ?? '';
  }
  
  public function validar() {
    if (!$this->nombre) {
      self::$errores[] = "Debes añadir un Nombre";
    }
    if (!$this->tipoLista) {
      self::$errores[] = "Debes seleccionar un Tipo de Lista";
    }
    return self::$errores;
  }

}