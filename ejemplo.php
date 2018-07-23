<?php
require_once './vendor/Requests/library/Requests.php';

Requests::register_autoloader();

// Asignación de headers
$headers = array('Accept' => 'application/json');

// Credenciales (si requiere autenticación)
$options = array();
#$options = array('auth' => array('user', 'pass'));

// Ejecución de la consulta
$response = Requests::get('https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-documento/1', $headers, $options);
$collection_respose = Requests::get('https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-documento', $headers, $options);

var_dump($response->status_code);
// int(200)

var_dump($response->headers['content-type']);
// string(31) "application/json; charset=utf-8"

var_dump($response->body);
// string(xxxx) "[...]"

// Mapeos Simples
// Arreglo de objetos
var_dump(json_decode($collection_respose->body));
// Arreglo de arreglos
var_dump(json_decode($collection_respose->body, true));
$regExp = '#^(\/[a-zA-Z0-9\/]+?)(\ .*?)$#i';
$tmp = preg_match($regExp,"/reservar 39801478 17-11-2017 15:00" , $aResults);
$cmd = trim($aResults[1]);
$cmd_params = explode(" ", $aResults[2]);
var_dump($cmd);
var_dump($cmd_params);
 ?>
