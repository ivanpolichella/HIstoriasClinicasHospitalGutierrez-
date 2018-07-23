<?php
require_once("ApiTurnos.php");
  if (isset($_GET['dni']) && isset($_GET['fecha']) && isset($_GET['hora']) ) {
    $result = ApiTurnos::getInstance()->reservar($_GET['dni'],$_GET['fecha'],$_GET['hora']);
    echo"$result";
    return $result;
  }

?>
