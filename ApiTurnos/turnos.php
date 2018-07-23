<?php
require_once("ApiTurnos.php");
  if (isset($_GET['fecha'])) {
    $result = ApiTurnos::getInstance()->turnos($_GET['fecha']);
    echo"$result";
    return $result;
  }

?>
