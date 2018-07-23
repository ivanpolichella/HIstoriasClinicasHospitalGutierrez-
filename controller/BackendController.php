<?php
require_once("view/Render.php");
require_once("model/modelUser.php");
if (!isset($_SESSION)){
  session_start();
}

class BackendController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
    }

    public static function verificarBackend() {
         if ( isset($_SESSION['email'])){
            $datos = array();
            $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
            $datos['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
            $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
            renderizar('templates/','indexView', $datos);
         }else{
           $datos = array('mensaje' => "acceso no permitido");
           header('location:index.php');
         }
      }

      public function mensajeError($msj){
        $datos = array();
        $datos['mensaje'] = $msj;
        renderizar('templates/','mensajeErrorBackEnd',$datos);
      }

}

?>
