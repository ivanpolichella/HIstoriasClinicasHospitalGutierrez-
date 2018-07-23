<?php
require_once("../model/modelTurno.php");

class ApiTurnos{
  private static $instance;

  public static function getInstance() {

      if (!isset(self::$instance)) {
          self::$instance = new self();
      }

      return self::$instance;
  }

  function __construct(){

  }

  private function verificarHora($hora)
  {
    $horas = array();
    $h = 8;
    $m = 30;
    $horas["08:00"] = 'Disponible';
    $horas["08:30"] = 'Disponible';
    while ($h < 20){
        $m += 30;
        if($m == 60){
          $m = 0;
          $h += 1;
        }
        if (($m == 0) and ($h < 10)){
          $horas["0".$h.":"."00"] = 'Disponible';
        }
        elseif ($h < 10)
          $horas["0".$h.":".$m] = 'Disponible';
          elseif ($m == 0)
            $horas[$h.":"."00"] = 'Disponible';
            else
              $horas[$h.":".$m] = 'Disponible';
    }
    return(isset($horas[$hora]));

  }

  public function help(){
    $msg['turnos'] = 'dd-mm-aaaa Muestra los turnos disponibles del dia';
    $msg['reservar']= 'DNI dd-mm-aaaa hh:mm Realiza la reserva del turno';
    $msg['help'] = 'Muestra este listado de comandos';
    return(json_encode($msg));
  }


  public function reservar($dni,$fecha,$hora){
    $aux = substr($fecha,0,2).'-';
    $aux .=substr($fecha,3,2).'-';
    $aux .=substr($fecha,6,4);
    $date = date_create($aux);
    $date = date_format($date,'Y-m-d');
    if ($date && $date >= (date('Y-m-d'))) {
      if($this->verificarHora($hora)){
        if (modelTurno::getInstance()->disponible($date,$hora)){
          $numero = modelTurno::getInstance()->reservar($dni,$date,$hora);
          $msg['estado']  = 'true';
          $msg['turno'] = $numero.PHP_EOL;
        }else {
          $msg['estado'] = 'false';
          $msg['error'] = 'Turno no Disponible, consulte los turnos disponibles';
        }
      }else {
        $msg['estado'] = 'false';
        $msg['error'] = 'Ingrese un horario valido, recuerde que los turnos son cada 30m Exactos.';
      }
    }else {
      $msg['estado'] = 'false';
      $msg['error'] = 'Ingrese una fecha valida';
    }
      return(json_encode($msg));
  }

  public function turnos($date){
    $fecha = $date;
    $aux = substr($fecha,0,2).'-';
    $aux .=substr($fecha,3,2).'-';
    $aux .=substr($fecha,6,4);
    $date = date_create($aux);
    if ($date) {
      $date = date_format($date,'Y-m-d');
      $turnosDisponibles = modelTurno::getInstance()->turnosDisponibles($date);
      return(json_encode($turnosDisponibles));
    }else {
          return json_encode(array('mensaje' => 'Ingrese una fecha valida'));
    }
  }

//enviando respuesta
//   public function enviar($msg){
//     $url = 'https://api.telegram.org/bot494762044:AAHk5KJ8bwbeb6rkJlufuCZcQ1JkVvKekRs/sendMessage';
//     $options = array(
//     'http' => array(
//         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//         'method'  => 'POST',
//         'content' => http_build_query($msg)
//         )
//     );
//
//     $context  = stream_context_create($options);
//     $result = file_get_contents($url, false, $context);
//
//     exit(0);
//   }
}
?>
