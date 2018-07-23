<?php
require_once("model/modelUser.php");
require_once("controller/BackendController.php");
require_once("view/Render.php");


class LoginController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
      @session_start();
    }


    public function verificarUsuario($email, $password){
      $email = htmlentities($email);
      $password = htmlentities($password);
      if (modelUser::getInstance()->verificarEmail($email)){
        $hash = modelUser::getInstance()->getPassword($email);
        if (password_verify($password, $hash[0])){
          $user = modelUser::getInstance()->getUser($email);
          $idUser = $user[0]['idUsuario'];
          $idRol = modelUser::getInstance()->getIdRol($idUser);
          $esta_habilitado = modelSettings::getInstance()->getHabilitado();
          $usr_activado = $user[0]['activo'];
          if ($usr_activado == 1){
            self::getInstance()->mensajeError('Usuario Bloqueado, comuniquese con el administrador');
          }
          else{
            //si el sistema está deshabilitado, pero sos administrador, entrás igual
            if( ($esta_habilitado == 'si' ) || (in_array('1',$idRol[0])) ){
              $_SESSION['idUser'] = $idUser;
              $_SESSION['email'] = $email;
              $_SESSION['idRol'] = $idRol[0]['idRol'];
              $datos = array();
              $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
              $datos['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
              $datos['session']=true;
              $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
              renderizar('templates/','indexView',$datos);
            }else{
              $this->mensajeError('Estamos en Mantenimiento, intente nuevamente más tarde');
            }
          }
        } else {
          $this->mensajeError('contraseña incorrecta.');
        }
      } else{
        $this->mensajeError('email incorrecto.');
      }

    }

    public function mensajeError($value)
    {
      $datos = array('mensaje' => $value );
      session_destroy();
      renderizar('templates/','loginView', $datos);
    }

    public static function sessionDestroy(){
      session_destroy();
    }

}

?>
