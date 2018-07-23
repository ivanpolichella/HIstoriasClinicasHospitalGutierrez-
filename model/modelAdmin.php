<?php
  require_once("model/PDOConnection.php");


  class modelAdmin{
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
    }

    private function consulta($query){
      $model = new PDOConnection;
      $connection = $model->getConnection();
      $stmt = $connection->prepare($query);
      if ($stmt) {
        $stmt->execute();
        $resultado = $stmt->fetchAll();
           return ($resultado);
      }
    }
//retorna los usuarios del modelo para el administrador
    public function getUsers(){
      $query = "SELECT * FROM usuario ";
      return self::getInstance()->consulta($query);
    }
//retorna los usuarios del modelo que contienen el string $busqueda en su username
    public function getUsersLike($busqueda){
      $query = "SELECT * FROM usuario WHERE username LIKE '%$busqueda%' ";
      return $this->consulta($query);
    }

    public function getUsersFiltered($filtro){
      $query = "SELECT * FROM usuario";
      if ($filtro == "activos") {
        $query = "SELECT * FROM usuario WHERE activo = 0";
      }
      else {
        if ($filtro == "bloqueados") {
          $query = "SELECT * FROM usuario WHERE activo = 1";
        }
      }
      return $this->consulta($query);
    }

    public function getUsersLikeAndFiltered($busqueda,$filtro){
      if ($filtro == "activos") {
        $query = "SELECT * FROM usuario WHERE (username LIKE '%$busqueda%') and (activo = 0)";
      }
      else {
        if ($filtro == "bloqueados") {
          $query = "SELECT * FROM usuario WHERE (username LIKE '%$busqueda%') and (activo = 1)";
        }
      }
      return $this->consulta($query);
    }

//retorna los tipos de usuarios
    public function getTypeUsers(){
      $query = "SELECT * FROM rol";
      return $this->consulta($query);
    }

    public function nuevaConfiguracion($titulo,$habilitado,$cantidad_listado,$email,$infoHospital,$infoGuardia,$infoEspecialidades)
    {
      $query = "UPDATE configuracion SET cantidad_listado='$cantidad_listado', habilitado='$habilitado', titulo='$titulo', email='$email', descripcionHospital='$infoHospital', descripcionEspecialidades='$infoEspecialidades', descripcionGuardia='$infoGuardia'";
      $this->consulta($query);
    }

    public function altaUsuario($email,$user_name,$nombre,$apellido,$password)
    {
      $query = "INSERT INTO usuario (email, username, firstName, lastName, password) VALUES ('$email','$user_name','$nombre','$apellido','$password')";
      $this->consulta($query);
    }

    public function getAllRol()
    {
      $model = new PDOConnection;
      $connection = $model->getConnection();
      $query = " SELECT nombre FROM rol ";
      $stmt = $connection->prepare($query);
      if($stmt){
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return ($resultado);
      }
    }

    public function idRol($nombre)
    {
      $model = new PDOConnection;
      $connection = $model->getConnection();
      $query = " SELECT idRol FROM rol WHERE rol.nombre = '$nombre' ";
      $stmt = $connection->prepare($query);
      if($stmt){
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return ($resultado[0]["idRol"]);
      }
    }

    public function getIdUser($mail)
    {
      $model = new PDOConnection;
      $connection = $model->getConnection();
      $query = " SELECT idUsuario FROM usuario WHERE usuario.email = '$mail' ";
      $stmt = $connection->prepare($query);
      if($stmt){
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return ($resultado[0]["idUsuario"]);
      }
    }


//paginacion

    public function getCantPaginas()
    {
      $model = new PDOConnection;
      $connection = $model->getConnection();
      $query = " SELECT cantidad_listado FROM configuracion";
      $stmt = $connection->prepare($query);
      if($stmt){
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return ($resultado[0]);
      }
    }


//manejo de usuarios
    public function altaUsuarioRol($idRol,$idUser)
    {
      $query = " INSERT INTO usuarioTieneRol (idUsuario, idRol) VALUES ('$idUser', '$idRol') ";
      $this->consulta($query);
    }

    public function actualizarUsuario($id,$email,$nombre,$apellido)
    {
      $query = "UPDATE usuario SET email = '$email', firstName = '$nombre', lastName = '$apellido' WHERE usuario.idUsuario = '$id'";
      $this->consulta($query);
    }

    public function actualizarPassword($id,$pass)
    {
      $query = "UPDATE usuario SET password = '$pass' WHERE usuario.idUsuario='$id'";
    }
    public function cambiarRol($rol,$idUser)
    {
      $idRol = self::getInstance()->idRol($rol);
      $query = "UPDATE usuarioTieneRol SET idRol = '$idRol' WHERE idUsuario = $idUser";
      $this->consulta($query);
    }
    public function bloquearUsuario($idUsr)
    {
      $query = "UPDATE usuario SET activo = 1 WHERE usuario.idUsuario = $idUsr";
      $this->consulta($query);
    }

    public function activarUsuario($idUsr)
    {
      $query = "UPDATE usuario SET activo = 0 WHERE usuario.idUsuario = $idUsr";
      $this->consulta($query);
    }

    public function eliminarUsuario($idUsr)
    {
      $query = "DELETE FROM usuario WHERE idUsuario = $idUsr";
      $this->consulta($query);
    }
    public function eliminarRevision($id)
    {
      $query = "DELETE FROM controlSalud WHERE idControlSalud = $id";
      $this->consulta($query);
    }
    public function borrarRolesDe($idUsuario)
    {
      $query= "DELETE FROM usuarioTieneRol WHERE idUsuario=$idUsuario";
      $this->consulta($query);
    }
    public function getIdRol($name)
    {
      $query= "SELECT idRol FROM rol WHERE nombre='$name'";
      return $this->consulta($query)[0]['idRol'];
    }
}
