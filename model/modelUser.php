<?php
  require_once("model/PDOConnection.php");


  class modelUser{
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

    public function getNombre($id)
    {
      $query="SELECT firstName,lastName FROM usuario WHERE idUsuario = $id";
      $model = new PDOConnection;
      $connection = $model->getConnection();
      $stmt = $connection->prepare($query);
      if ($stmt) {
        $stmt->execute();
        $resultado = $stmt->fetchAll();
           return ($resultado[0]);
    }
  }

  public function getNombresPediatras()
  {
    $query="SELECT firstName,lastName FROM usuario ORDER BY idUsuario";
    $model = new PDOConnection;
    $connection = $model->getConnection();
    $stmt = $connection->prepare($query);
    if ($stmt) {
      $stmt->execute();
      $resultado = $stmt->fetchAll();
         return ($resultado);
  }
  }

    public function verificarEmail($email)
    {
      $model = new PDOConnection();
      $connection = $model -> getConnection();
      $query = "SELECT email FROM usuario WHERE email = '$email' ";
      $stmt = $connection->prepare($query);
      $stmt->execute();
      return ($stmt->rowCount() != 0 );
    }

    public function getPassword($email)
    {
      $model = new PDOConnection();
      $connection = $model -> getConnection();
      $query = "SELECT password FROM usuario WHERE email = '$email' ";
      $stmt = $connection->prepare($query);
      $stmt->execute();
      $resultado = $stmt->fetch();
      return ($resultado );
    }

    public function isAdministrator($idUsuario)
    {
      $model = new PDOConnection();
      $connection = $model -> getConnection();
      $query = "SELECT idRol FROM usuarioTieneRol WHERE idUsuario = '$idUsuario' AND idRol = 1 ";
      $stmt = $connection->prepare($query);
      $stmt->execute();
      return ( $stmt->rowCount() != 0 );
    }

    public function isPediatra($idUsuario)
    {
      $model = new PDOConnection();
      $connection = $model -> getConnection();
      $query = "SELECT idRol FROM usuarioTieneRol WHERE idUsuario = '$idUsuario' AND idRol = 2 ";
      $stmt = $connection->prepare($query);
      $stmt->execute();
      return ( $stmt->rowCount() != 0 );
    }

    public function validarUsuario($email, $password){
      $model = new PDOConnection();
      $connection = $model->getConnection();
      $query = "SELECT * FROM usuario WHERE email =:mail AND password=:pass ";
      $stmt = $connection->prepare($query);
      $stmt->bindParam(':mail',$email);
      $stmt->bindParam(':pass',$password);
      if($stmt){
        $stmt->execute();
        return ( $stmt->rowCount() != 0 );
      }
    }


    public function getIdRol($idUser){
      $query = " SELECT idRol FROM usuarioTieneRol WHERE usuarioTieneRol.idUsuario = $idUser ";
      return (self::getInstance()->consulta($query));
    }

    public function getNameRolOfUser($idUser)
    {
      $model = new PDOConnection();
      $connection = $model->getConnection();
      $query = "SELECT nombre FROM usuarioTieneRol utr INNER JOIN rol ON utr.idRol = rol.idRol WHERE utr.idUsuario = '$idUser'";
      $stmt = $connection->prepare($query);
      if($stmt){
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return ($resultado);
      }
    }

    public function getNameRol($idUser){
      $query = " SELECT nombre FROM usuarioTieneRol NATURAL JOIN rol WHERE usuarioTieneRol.idUsuario = $idUser ";
      return ($this->consulta($query));
    }

    public function getRoles($idUser){
      $query = " SELECT idRol,nombre FROM usuarioTieneRol NATURAL JOIN rol WHERE usuarioTieneRol.idUsuario = $idUser ";
      return ($this->consulta($query));
    }


    public function getIdPermiso($permiso){
        $model = new PDOConnection();
        $connection = $model->getConnection();
        $query = " SELECT DISTINCT idPermiso FROM permiso WHERE permiso.nombre = '$permiso' ";
        $stmt = $connection->prepare($query);
        if($stmt){
          $stmt->execute();
          $resultado = $stmt->fetchAll();
          return ($resultado[0]);
        }
    }

    public function getAllPermissionsOfUser($idUsuario)
    {
      $model = new PDOConnection();
      $connection = $model->getConnection();
      $query = "SELECT DISTINCT permiso.nombre FROM usuarioTieneRol utr INNER JOIN rolTienePermiso rtp INNER JOIN permiso ON utr.idRol = rtp.idRol AND rtp.idPermiso = permiso.idPermiso  WHERE utr.idUsuario = '$idUsuario' ";
      $stmt = $connection->prepare($query);
      if ($stmt){
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return ($resultado);
      }
    }

    public function getPermissions($idRol)
    {
      $query = "SELECT nombre FROM rolTienePermiso INNER JOIN permiso WHERE rolTienePermiso.idPermiso = permiso.idPermiso AND rolTienePermiso.idRol = '$idRol'";
      return ($this->consulta($query));
    }

    //con el email te devuelve todo los campos del Usuario
    public function getUser($email){
      $query = " SELECT * FROM usuario WHERE usuario.email = '$email' ";
      return ($this->consulta($query));
    }

    //recibe un ID de usuario y un nombre de permiso, devuelve el ID del permiso si lo tiene habilitado
    public function checkPermissions($permission, $idUser){
      $model = new PDOConnection();
      $connection = $model->getConnection();
      $permis = self::getInstance()->getIdPermiso($permission);
      $perm = $permis["idPermiso"];
      $query = " SELECT idPermiso FROM permiso WHERE idPermiso='$perm' AND idPermiso IN (SELECT DISTINCT rtp.idPermiso from usuarioTieneRol utr inner join rolTienePermiso rtp on utr.idRol=rtp.idRol  where utr.idUsuario='$idUser') ";
      $stmt = $connection->prepare($query);
      if ($stmt){
        $stmt->execute();
        $resultado = $stmt->rowCount();
        return ($resultado);
      }
    }


  }

?>
