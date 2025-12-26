<?php

namespace Model;

class ActiveRecord {

  // Base de Datos
  protected static $db;
  protected static $columnasDB = [];
  protected static $tabla = '';

  // Errores
  protected static $errores = [];



  // Definir la conexion a la base de datos. Al ser static $db el metodo tambien debe ser static
  public static function setDB ($database) {
    self::$db = $database;   // este queda en self para que lo tome de la clase padre (esta) porque la BD no cambia
  }

  public function guardar() {
    if(!is_null($this->id)) {     // OJO !!  isset revisa que el atributo exista pero no si tiene un valor. Si en el constructor lo fuerzo a null, aca puedo usar is_null
      $this->actualizar();
    } else {
        $this->crear();
    }
  }

  public function crear() {
    // Sanitizar los datos
    $atributos = $this->sanitizarAtributos();
    
    $query = " INSERT INTO " . static::$tabla . " ("; 
    $query .= join(", ", array_keys($atributos) );
    $query .= ") VALUES ('";
    $query .= join("', '", array_values($atributos) );
    $query .= "')";               

    $resultado = self::$db->query($query);    
    if($resultado) {          
      header('Location: /articulos?resultado=1');
    }    
  }
  
  public function actualizar()  {
    $atributos = $this->sanitizarAtributos();
    $valores = [];
    foreach($atributos as $key => $value) {
      $valores[] = "{$key}='{$value}'";
    }
    
     $query = " UPDATE " . static::$tabla . " SET ";
     $query .= join(', ', $valores);
     $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
     $query .= " LIMIT 1 ";

     $resultado = self::$db->query($query);  
     if($resultado) {          
       header('Location: /articulos?resultado=2');
       exit;
     }
  }

  // Eliminar un registro
  public function eliminar() {
    $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1 ";
    $resultado = self::$db->query($query);  
    if ($resultado) {
      header ('location: /categorias?resultado=3');
      exit;
    }
  }

  // Eliminar un articulo
  public function eliminarArticulo() {
    $id = self::$db->escape_string($this->id);
    
    $queryRelacionado = "DELETE FROM listaarticulos WHERE articulos_id = $id";
    self::$db->query($queryRelacionado);  

    $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1 ";
    $resultado = self::$db->query($query);  
    if ($resultado) {
      $this->borrarImagen();
      header ('location: /articulos?resultado=3');
      exit;
    }
  }


  // creo un nuevo arreglo con las columnas tomados del arreglo y los valores tomados del objeto en memoria
  public function atributos() {
    $atributos = [];
    foreach(static::$columnasDB as $columna) {
      if ($columna === 'id') continue;
      $atributos[$columna] = $this->$columna;
    }
    return $atributos;
  }

    
  public function sanitizarAtributos() {
    $atributos = $this->atributos();
    $sanitizado = [];
    foreach ($atributos as $key => $value )  {
      $sanitizado [$key] = self::$db->escape_string($value);
    }
    return $sanitizado;
  }


  // Validacion
  public static function getErrores() {
    return static::$errores;
  }
  
  public function validar() {    
    static::$errores = [];    
    return static::$errores;
  }  

  // lista todas las registros
  public static function all() {
    $query = "SELECT * FROM " . static::$tabla;   // en lugar de self que toma la clase actual, uso static que toma la clase que instancio...
    // la consulta a la base de datos devuelve un arreglo y el patron active record requiere tener un array de objetos
    $resultado = self::consultarSQL($query);
    return $resultado;
  }

  // listas con datos asociados
  public static function allListas() {    
    $query = "SELECT l.id, l.nombre, l.tipolista, l.fechacreacion, l.imagen, l.descripcion, COUNT(la.articulos_id) as k_articulos 
    FROM listas l LEFT JOIN listaarticulos la on la.listas_id = l.id 
    GROUP BY l.id, l.nombre, l.tipolista, l.fechacreacion, l.imagen, l.descripcion 
    ORDER BY l.id";            
    $resultado = self::consultarSQL($query);
    return $resultado;
  }  

  // lista todos los articulos elegidos de una determinada lista
  public static function allArticulosElegidos($idLista)  {
    $query = "SELECT lar.id as idLP, lar.*, art.*, lis.nombre AS nombrelista, lis.tipoLista , cat.nombre as nombreCat FROM listaarticulos lar 
    LEFT JOIN articulos art ON lar.articulos_id = art.id 
    LEFT JOIN listas lis ON lar.listas_id = lis.id
    LEFT JOIN categorias cat ON art.categorias_id = cat.id
    WHERE listas_id = {$idLista}
    ORDER BY cat.nombre, art.nombre";
    $resultado = self::consultarSQL($query);
    return $resultado;
  }
  
  // lista todos los articulos disponibles de una determinada lista
  public static function allArticulosDisponibles($idLista, $tipoLista)  {
    $query = "SELECT cat.nombre AS nombrecat, art.nombre AS nombreart, cat.*, art.* FROM categorias cat 
    INNER JOIN articulos art ON art.categorias_id = cat.id
    WHERE cat.tipoLista = {$tipoLista}
    AND art.id NOT IN (SELECT articulos_id FROM listaarticulos WHERE listas_id = {$idLista})
    ORDER BY cat.nombre, art.nombre";      
    $resultado = self::consultarSQL($query);
    return $resultado;
  }
  

  // lista articulos disponibles de una determinada lista y categoria
  public static function allArticulosListaCategoria($idLista, $idCat) {
    $query = "SELECT art.id as idarticulo, lar.*, art.*,
    CASE WHEN lar.articulos_id IS NOT NULL THEN 1 ELSE 0 END as incluido
    FROM articulos art
    LEFT JOIN listaarticulos lar ON lar.articulos_id = art.id AND lar.listas_id = {$idLista}  
    WHERE art.categorias_id = {$idCat}      
    ORDER BY art.nombre";
    $resultado = self::consultarSQL($query);
    return $resultado;    
  }

  // lista todas los articulos
  public static function allArticulosConCategorias() {    
    $query = "SELECT art.*, cat.nombre as nombreCat FROM articulos art INNER JOIN categorias cat ON art.categorias_id = cat.id";
    // la consulta a la base de datos devuelve un arreglo y el patron active record requiere tener un array de objetos
    $resultado = self::consultarSQL($query);
    return $resultado;
  }

  // lista todas las categorias de un determinado tipo de lista
  public static function allCategoriasDeUnTipoLista($tipoLista) {    
    $query = "SELECT * FROM categorias WHERE tipoLista = {$tipoLista} ORDER BY nombre";
    // la consulta a la base de datos devuelve un arreglo y el patron active record requiere tener un array de objetos
    $resultado = self::consultarSQL($query);
    return $resultado;
  }

  // Agregar articulo a la lista
  public static function insertListaArticulo($idLista, $idArticulo) {
    $query = "INSERT INTO listaarticulos (cantidad, listas_id, articulos_id) 
    VALUES (1, $idLista, $idArticulo)";     
    $resultado = self::$db->query($query);  
    return $resultado;
  }

  // Agregar articulo a la lista
  public static function deleteListaArticulo($idLista, $idArticulo) {
    $query = "DELETE FROM listaarticulos WHERE listas_id = {$idLista} AND articulos_id = {$idArticulo}";    
    $resultado = self::$db->query($query);  
    return $resultado;
  }


  // busca un registro por su id
  public static function find($id) {
    $query = "SELECT * FROM " . static::$tabla . " WHERE id ={$id}";    
    $resultado = self::consultarSQL($query);
    return array_shift($resultado);
  }


  public static function consultarSQL($query) {
    // consultar la base de datos
      $resultado = self::$db->query($query);
    // iterar los resultados
      $array = [];
      while ($registro = $resultado->fetch_assoc()) {
        $array[] = static::crearObjeto($registro);
      }      
    // liberar la memoria
      $resultado->free();
    // retornar los resultados
      return $array;
  }

  protected static function crearObjeto($registro) {
    $objeto = new static; // crea un nuevo objeto categoria
    foreach($registro as $key => $value) {
      if( property_exists($objeto,$key) ) {  // cuando exista la propiedad armo el objeto
        $objeto->$key = $value;
      }
    }
    return $objeto;
  }


  // Sincroniza el objeto en memoria con los cambios realizados por el usuario
  public function sincronizar($args = []) {
    foreach($args as $key => $value) {
      if( property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }


    public function setImagen($imagen) {
      // Elimina la imagen previa (se da cuenta si habia una, si tengo un "id", porque eso significa que estoy editando, no creando)¨
      if( !is_null($this->id) ) {
        $this->borrarImagen();
      }
      // asignar al atributo de imagen, el nombre de la imagen
      if($imagen) {
        $this->imagen = $imagen;
      }
    }

    // Borrar imagen
    public function borrarImagen()  {
      // verificar el existe el archivo
      $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
      if($existeArchivo) {
        unlink(CARPETA_IMAGENES . $this->imagen);
      }      
    }





}