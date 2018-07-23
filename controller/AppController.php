<?php

require_once("view/Render.php");
require_once("model/modelUser.php");
if (!isset($_SESSION)){
    session_start();
}

class AppController{

  private static $instance;
  private static $user;

  public static function getInstance(){
    if (!isset(self::$instance)){
      self::$instance = new self();
    }
    return self::$instance;
  }

  private function __construct(){
  }

  public function addUser(){

  }

  public static function getUser(){
    if(!isset(self::$user)){
      if (isset($_SESSION['idUser'])) {
        $user = $_SESSION['idUser'];
        return $user;
      }
    }
    return self::$user;
  }

  public static function checkPermissions($permision){
    //check si el usuario tiene permitido $permision
    $idUser = self::getUser();
    return (modelUser::getInstance()->checkPermissions($permision, $idUser) == 1);
    // return self::getUser().checkPermissions($permision);
  }

}

?>
