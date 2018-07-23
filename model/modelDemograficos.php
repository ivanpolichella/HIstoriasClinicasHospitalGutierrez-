<?php
require_once("model/PDOConnection.php");

class modelDemograficos{
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

  public function getDatosDemograficos($idDatosDemograficos){
    $query = "SELECT * FROM datosDemograficos INNER JOIN tipoVivienda AS tipoV ON tipoViviendaId=tipoV.idTipoVivienda
      INNER JOIN tipoCalefaccion AS tipoC ON tipoCalefaccionId=tipoC.idTipoCalefaccion
      INNER JOIN tipoAgua  AS tipoA ON tipoAguaId=tipoA.idTipoAgua WHERE idDatosDemograficos='$idDatosDemograficos'";
    return $this->consulta($query)[0];
  }

  public function getTipoCalefaccion()
  {
    $query="SELECT * FROM tipoCalefaccion";
    return $this->consulta($query);
  }

  public function getTipoVivienda()
  {
    $query="SELECT * FROM tipoVivienda";
    return $this->consulta($query);
  }

  public function getTipoAgua()
  {
    $query="SELECT * FROM tipoAgua";
    return $this->consulta($query);
  }
  public function cantidadViviendasTipo($idVivienda)
  {
    $query="SELECT COUNT(tipoViviendaId) as cantidad FROM datosDemograficos WHERE tipoViviendaId='$idVivienda'";
    $model = new PDOConnection;
    $connection = $model->getConnection();
    $stmt = $connection->prepare($query);
    if ($stmt) {
      $stmt->execute();
      $resultado = $stmt->fetch();
         return ($resultado[0]);
    }
  }
}
?>
