<?php
  require_once("ApiTurnos.php");
  $result = ApiTurnos::getInstance()->help();
  echo"$result";
  return $result;

?>
