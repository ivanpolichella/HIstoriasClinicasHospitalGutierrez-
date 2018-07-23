<?php

  class PDOConnection{
    public function getConnection(){
      $user = "root";
      //NmMxNDgzY2UzM2Rj
      $password = "";
      $host = "localhost";
      $db = "grupo8";
      $connection = new PDO("mysql:host=$host;dbname=$db;",$user,$password);
      return $connection;
    }
  }

?>
