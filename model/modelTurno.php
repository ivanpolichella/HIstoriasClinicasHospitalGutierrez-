<?php
require_once("PDOConnection.php");

class modelTurno{
  private static $instance;
  private static $horas;

  public static function getInstance() {
      if (!isset(self::$instance)) {
          self::$instance = new self();
      }

      return self::$instance;
  }

  private function __construct() {

    //Creación de un arreglo que contiene todos los horarios
				$h = 8;
				$m = 30;
				self::$horas["08:00"] = 'Disponible';
				self::$horas["08:30"] = 'Disponible';
				while ($h < 20){
  					$m += 30;
  					if($m == 60){
  						$m = 0;
  						$h += 1;
  					}
  					if (($m == 0) and ($h < 10)){
  						self::$horas["0".$h.":"."00"] = 'Disponible';
            }
  					elseif ($h < 10)
  						self::$horas["0".$h.":".$m] = 'Disponible';
  						elseif ($m == 0)
  							self::$horas[$h.":"."00"] = 'Disponible';
  							else
  								self::$horas[$h.":".$m] = 'Disponible';
        }
  }

  private function consulta($query){
    $model = new PDOConnection;
    $connection = $model->getConnection();
    $stmt = $connection->prepare($query);
    $stmt->execute();
    return $stmt;
  }
  //retorna todos los turnos dados de una fecha.
  private function getTurnos($fecha) {
    $query = "SELECT * from turno WHERE fecha = '$fecha'";
    return ($this->consulta($query)->fetchAll());
  }
  //retorna un booleano dependiendo si el turno en la fecha y hora indicada está disponible
  public function disponible($fecha,$hora){
    $query = "SELECT * from turno WHERE turno.fecha = '$fecha' AND turno.hora = '$hora'";
    return ($this->consulta($query)->rowCount() == 0 );

  }
  //retorna los turnos disponibles de una determinada fecha
  public function turnosDisponibles($fecha){
    $turnos = $this->getTurnos($fecha);
    foreach ($turnos as $turno) {
      unset(self::$horas[substr($turno['hora'],0,5)]);
    }
    return (self::$horas);
  }

  //reserva un turno con los parametros indicados, retorna un numero de turno o error en caso de no poder reservar
  public function reservar($dniPaciente, $fecha,$hora){
    $model = new PDOConnection;
    $connection = $model->getConnection();
    $query = "INSERT INTO turno (idTurno,fecha,hora,dniPaciente) VALUES (NULL,'$fecha','$hora','$dniPaciente')";
    $connection->beginTransaction();
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $ultimosId = $connection->lastInsertId();
    $connection->commit();
    return $ultimosId;
  }

}
?>
