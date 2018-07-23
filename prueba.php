<?php
require_once('./vendor/Requests/library/Requests.php');

Requests::register_autoloader();
// Asignación de headers
$headers = array('Accept' => 'application/json');

// Credenciales (si requiere autenticación)
$options = array();
#$options = array('auth' => array('user', 'pass'));


switch ($_GET['comando']) {
case '/start':
  $msg['text']  = 'Hola ' . $response['message']['from']['first_name'] .
             " Usuario: " . $response['message']['from']['username'] . '!' . PHP_EOL;
  $msg['text'] .= 'Puede solicitar o consultar Turnos con mi ayuda /help';
break;

case '/help':
    $msg['text']  = 'Los comandos disponibles son estos:' . PHP_EOL;
    $msg['text'] .= '/start Inicializa el bot' . PHP_EOL;
    $msg['text'] .= '/turnos dd-mm-aaaa Muestra los turnos disponibles del día' . PHP_EOL;
    $msg['text'] .= '/reservar DNI dd-mm-aaaa hh:mm Realiza la reserva del turno' . PHP_EOL;
    $msg['text'] .= '/help Muestra este listado de comandos';
    break;

case '/reservar':
    // $dni = $cmd_params[1];
    // $fecha = $cmd_params[2];
    // $hora = $cmd_params[3];
    // $respuestaApi = Requests::get('https://grupo8.proyecto2017.linti.unlp.edu.ar/ApiTurnosTelegram.php/reservar.php?dni='.$dni.'&fecha='.$fecha.'&hora='.$hora, $headers, $options);
    // if ($respuestaApi->status_code == 200){
    //   $mensaje = (json_decode($respuestaApi->body, true));
    //   if ($mensaje['estado'] == 'true') {
    //     $msg['text'] = 'Se reservó un turno para el día'.$fecha.'A las: '.$hora.' N°'.$mensaje['turno'];
    //   }else {
    //     $msg['text'] = $mensaje['error'];
    //   }
    // }else {
    //   $msg['text'] = 'El sistema de turnos no está habilitado';
    // }
    // //$msg['text']  =  ApiTurnosTelegram::getInstance()->reservar($dni,$fecha,$hora);
    // break;
    echo "reservar";

 case '/turnos':
    $fecha = $_GET['fecha'];
    $respuestaApi = Requests::get('https://grupo8.proyecto2017.linti.unlp.edu.ar/ApiTurnos/turnos.php?fecha='.$fecha, $headers, $options);
    if ($respuestaApi->status_code == 200){
      $turnosDisponibles = (json_decode($respuestaApi->body, true));
      var_dump($turnosDisponibles);
      //$turnosDisponibles = json_decode($respuestaApi);
      if (isset($turnosDisponibles['mensaje']))
        $msg['text'] = $turnosDisponibles['mensaje'];
      else{
        $msg['text']  = 'Los turnos disponibles para el día: '.$_GET['fecha'].' son: '.PHP_EOL;
        foreach ($turnosDisponibles as $clave => $turno) {
          $msg['text'] .= $clave.' ';
          $msg['text'] .= ' '.$turno.PHP_EOL;
        }
      }
    }
    var_dump($msg);
    //$msg['text'] = ApiTurnosTelegram::getInstance()->turnos($fecha);
    break;

default:
    $msg['text']  = 'El comando ingresado no es correcto, necesita ayuda? -> /help';
    break;
}
//var_dump($msg);


?>
