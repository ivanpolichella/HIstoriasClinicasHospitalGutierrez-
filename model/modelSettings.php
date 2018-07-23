<?php
require_once("model/PDOConnection.php");

class modelSettings{
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

  public function getInfoHospital(){
    $query = "SELECT * FROM configuracion";
    return ($this->consulta($query)[0]);
  }

  public function getHabilitado()
  {

    $query = "SELECT habilitado FROM configuracion";
    $model = new PDOConnection;
    $connection = $model->getConnection();
    $stmt = $connection->prepare($query);
    if ($stmt) {
      $stmt->execute();
      $resultado = $stmt->fetchAll();
      return ($resultado[0]['habilitado']);
    }
  }
}

 ?>
