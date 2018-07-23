<?php

require_once("model/modelUser.php");
require_once("view/Render.php");
require_once("AppController.php");
require_once("model/modelAdmin.php");
if(!isset($_SESSION)){
  session_start();
}

class AdminController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
    }



     public function mostrarFormEditar($mail)
     {
       if (modelUser::getInstance()->isAdministrator($_SESSION['idUser'])) {
         $datos = array();
         $usuario = modelUser::getInstance()->getUser($mail);
         $roles = modelAdmin::getInstance()->getTypeUsers();
         $rolesDeUsuario = modelUser::getInstance()->getRoles($usuario[0]['idUsuario']);
         $datos['datos']=$usuario[0];
         $datos['roles'] = modelAdmin::getInstance()->getAllRol();
         $rolesUsuario = modelUser::getInstance()->getNameRolOfUser($datos['datos']["idUsuario"]);
         $rolesUsu = array();
         $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
         $datos['session'] = true;
         $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
         $datos['isAdm'] = true;
        foreach ($rolesUsuario as $rolesUsu) {
          $datos['tieneRol'][$rolesUsu["nombre"]] = true;
        }
         renderizar('templates/','adminEditUserView',$datos);
      }else {
        $datos = array('mensaje' => 'Acceso Denegado');
        renderizar('templates/','indexView', $datos);
      }
     }

    public function mostrarFormRegistro()
    {
      if (modelUser::getInstance()->isAdministrator($_SESSION['idUser'])) {
        $datos = array();
        $tipos_usuarios = modelAdmin::getInstance()->getTypeUsers();
        $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
        $datos['isAdm'] = true;
        $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
        $datos['session'] = true;
        $datos['tipos_usuarios'] = $tipos_usuarios;
        renderizar('templates/','adminAddUserView',$datos);
      }
    }

    public function configuracion(){
      if (modelUser::getInstance()->isAdministrator($_SESSION['idUser'])) {
        $datos = modelSettings::getInstance()->getInfoHospital();
        $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
        $datos['isAdm'] = true;
        $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
        $datos['session'] = true;
        renderizar('templates/','adminConfiguracionView',$datos);
      }else{
        header('Location:index.php?action=acceso_denegado');
      }
    }

    public function altaConfiguracion($titulo,$habilitado,$cantidad_listado,$email,$infoHospital,$infoGuardia,$infoEspecialidades)
    {
      if (modelUser::getInstance()->isAdministrator($_SESSION['idUser'])) {
        $titulo = htmlspecialchars($titulo);
        $cantidad_listado = htmlspecialchars($cantidad_listado);
        $habilitado = htmlspecialchars($habilitado);
        $email = htmlspecialchars($email);
        $infoHospital = htmlspecialchars($infoHospital);
        $infoGuardia = htmlspecialchars($infoGuardia);
        $infoEspecialidades = htmlspecialchars($infoEspecialidades);

        modelAdmin:: getInstance()->nuevaConfiguracion($titulo,$habilitado,$cantidad_listado,$email,$infoHospital,$infoGuardia,$infoEspecialidades);
        $datos = array('mensaje' => 'Se cambió la Configuracion del sistema Correctamente' );
        $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
        $datos['isAdm'] = true;
        $datos['session']=true;
        $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
        renderizar('templates/','indexView',$datos);
      }
    }

    public function agregarUsuario($email,$user_name,$nombre,$apellido,$password,$roles)
     {
       $password = htmlentities($password);
       $email = htmlentities($email);
       $nombre = htmlentities($nombre);
       $apelido = htmlentities($apellido);
       $roles = htmlentities($roles);
       $user_name = htmlentities($user_name);
       if (modelUser::getInstance()->isAdministrator($_SESSION['idUser'])) {
        $pass = password_hash($password, PASSWORD_DEFAULT);
        modelAdmin::getInstance()->altaUsuario($email,$user_name,$nombre,$apellido,$pass);
        $id_user = modelAdmin::getInstance()->getIdUser($email);
        foreach ($roles as $rol) {
          modelAdmin::getInstance()->altaUsuarioRol($rol,$id_user);
        }
        header('Location: index.php?action=listar&option=usuarios&indice=1');
       }
     }

    public function editarUsuario($email,$nombre,$apellido,$roles,$id)
     {
       $email = htmlentities($email);
       $nombre = htmlentities($nombre);
       $apelido = htmlentities($apellido);
       $id = htmlentities($id);
       if (modelUser::getInstance()->isAdministrator($_SESSION['idUser'])) {
        modelAdmin::getInstance()->actualizarUsuario($id,$email,$nombre,$apellido);
        if (isset($roles)) {
          modelAdmin::getInstance()->borrarRolesDe($id);
          foreach ($roles as $rol) {
            $idRol = modelAdmin::getInstance()->getIdRol($rol);
            modelAdmin::getInstance()->altaUsuarioRol($idRol,$id);
          }
        }
        header('Location: index.php?action=listar&option=usuarios&indice=1');
       }
     }

    public function bloquearUsuario($idUsr)
     {
       if (modelUser::getInstance()->isAdministrator($_SESSION['idUser'])) {
         modelAdmin::getInstance()->bloquearUsuario($idUsr);
         $mensaje = array('mensaje' => 'Usuario Bloqueado' );
         header('Location: index.php?action=listar&option=usuarios&indice=1');
       }
     }
    public function activarUsuario($idUsr)
    {
      if (modelUser::getInstance()->isAdministrator($_SESSION['idUser'])) {
        modelAdmin::getInstance()->activarUsuario($idUsr);
        header('Location: index.php?action=listar&option=usuarios&indice=1');
      }
    }
    public function eliminarUsuario($idUsr)
    {
      if (modelUser::getInstance()->isAdministrator($_SESSION['idUser'])) {
        modelAdmin::getInstance()->eliminarUsuario($idUsr);
        header('Location: index.php?action=listar&option=usuarios&indice=1');
      }
    }

    public function eliminarRevision($id)
    {
      if (modelUser::getInstance()->isAdministrator($_SESSION['idUser'])) {
        modelAdmin::getInstance()->eliminarRevision($id);
        header('Location: index.php?action=listar&option=pacientes&indice=1');
      }
    }

    public function prepararPaginacion($array,$indice)
    {
        $cantidad_listado = modelAdmin::getInstance()->getCantPaginas();
        $paginas = array();
        $cant_usuario = sizeof($array);
        $cantidad_paginas = ceil($cant_usuario/$cantidad_listado['cantidad_listado']);
        $usuarios_por_pagina = array();
        $guardados = 0;
        $i = 1;
        foreach ($array as $user) {
          $usuarios_por_pagina[$guardados]=$user;
          $guardados++;
          if ($guardados == $cantidad_listado['cantidad_listado']) {
            $paginas[$i] = $usuarios_por_pagina;
            $usuarios_por_pagina = array();
            $i++;
            $guardados = 0;
          }
          if ($guardados < $cantidad_listado['cantidad_listado'] and $guardados > 0) {
            $paginas[$i] = $usuarios_por_pagina;
          }
        }
        $paginas['cant_paginas'] = $cantidad_paginas;
        $paginas['indice'] = $indice;
        if (sizeof($paginas) == 2) {
          $paginas['vacio'] = 1;
        }
        else {
          $paginas['vacio'] = 0;
        }
        return($paginas);
    }
    }
?>
