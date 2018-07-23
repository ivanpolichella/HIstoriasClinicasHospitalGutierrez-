<?php
require_once('./vendor/Requests/library/Requests.php');

class ClienteTelegram{

  private static $instance;

  public static function getInstance() {

      if (!isset(self::$instance)) {
          self::$instance = new self();
      }

      return self::$instance;
  }

  function __construct()
  {
    # code...
  }
  public function execute(){
    Requests::register_autoloader();
    // Asignación de headers
    $headers = array('Accept' => 'application/json');

    // Credenciales (si requiere autenticación)
    $options = array();
    #$options = array('auth' => array('user', 'pass'));


    //recibiendo el comando

    $returnArray = true;
    $rawData = file_get_contents('php://input');
    $response = json_decode($rawData, $returnArray);
    $id_del_chat = $response['message']['chat']['id'];


    // Obtener comando (y sus posibles parametros)
    $regExp = '#^(\/[a-zA-Z0-9\/]+?)(\ .*?)$#i';


    $tmp = preg_match($regExp, $response['message']['text'], $aResults);

    if (isset($aResults[1])) {
        $cmd = trim($aResults[1]);
        $cmd_params = explode(" ", $aResults[2]);
    } else {
        $cmd = trim($response['message']['text']);
        $cmd_params = '';
    }

    //armando resupuesta
    $msg = array();
    $msg['chat_id'] = $response['message']['chat']['id'];
    $msg['text'] = null;
    $msg['disable_web_page_preview'] = true;
    $msg['reply_to_message_id'] = $response['message']['message_id'];
    $msg['reply_markup'] = null;
    $msg['reply_to_message_id'] = null;



    switch ($cmd) {
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
        $dni = $cmd_params[1];
        $fecha = $cmd_params[2];
        $hora = $cmd_params[3];
        $respuestaApi = Requests::get('https://grupo8.proyecto2017.linti.unlp.edu.ar/ApiTurnos/reservar.php?dni='.$dni.'&fecha='.$fecha.'&hora='.$hora, $headers, $options);
        if ($respuestaApi->status_code == 200){
          $mensaje = (json_decode($respuestaApi->body, true));
          if ($mensaje['estado'] == 'true') {
            $msg['text'] = 'Se reservó un turno para el día: '.$fecha.' A las: '.$hora.' N°'.$mensaje['turno'];
          }else {
            $msg['text'] = $mensaje['error'];
          }
        }else {
          $msg['text'] = 'El sistema de turnos no está habilitado';
        }
        break;

     case '/turnos':
        $fecha = $cmd_params[1];
        $respuestaApi = Requests::get('https://grupo8.proyecto2017.linti.unlp.edu.ar/ApiTurnos/turnos.php?fecha='.$fecha, $headers, $options);
        if ($respuestaApi->status_code == 200){
          $turnosDisponibles = (json_decode($respuestaApi->body, true));
          //$turnosDisponibles = json_decode($respuestaApi);
          if (isset($turnosDisponibles['mensaje']))
            $msg['text'] = $turnosDisponibles['mensaje'];
          else{
            $msg['text']  = 'Los turnos disponibles para el día: '.$fecha.' son: '.PHP_EOL;
            foreach ($turnosDisponibles as $clave => $turno) {
              $msg['text'] .= $clave.' ';
              $msg['text'] .= ' '.$turno.PHP_EOL;
            }
          }
        }
        break;

    default:
        $msg['text']  = 'El comando ingresado no es correcto, necesita ayuda? -> /help';
        break;
    }

    //enviando respuesta

    $url = 'https://api.telegram.org/bot494762044:AAHk5KJ8bwbeb6rkJlufuCZcQ1JkVvKekRs/sendMessage';
    $options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($msg)
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    exit(0);
  }
}

?>
