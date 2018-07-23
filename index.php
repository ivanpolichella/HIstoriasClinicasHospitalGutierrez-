<?php

require_once("view/Render.php");//Render de twig.
require_once("model/modelUser.php");
require_once("controller/LoginController.php");
require_once("controller/BackendController.php");
require_once("controller/AdminController.php");
require_once("controller/PacienteController.php");
require_once("model/modelSettings.php");
require_once('vendor/Requests/library/Requests.php');
require_once("scripts.js");
require_once("controller/ClienteTelegram.php");




if ( !isset($_SESSION) ){
  session_start();
}

if (isset($_GET["action"])){
  switch ($_GET["action"]) {
    case "login":
    if(!isset($_SESSION['email'])){
      $datos = array();
      $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
      renderizar('templates/','loginView', $datos);
    }else{
      header('location:index.php');
    }
    break;
    case "logincheck":
    if ( isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['password']) && $_POST['password'] != ""  ){
      LoginController::getInstance()->verificarUsuario($_POST['email'],$_POST['password']);
    }else{
      LoginController::getInstance()->mensajeError("Completar los datos correctamente");
    }
    break;
    case "destroy":
    LoginController::getInstance()->sessionDestroy();
    header('location:index.php');
    break;
    case "paciente_index":
    PacienteController::getInstance()->indexAction();
    break;
    case "paciente_new":
    PacienteController::getInstance()->newAction();
    break;
    case "paciente_update":
    PacienteController::getInstance()->updateAction($_GET['idPaciente'],$_GET['idDatosDemograficos']);
    break;
    case 'alta_paciente':
      if (isset($_POST['apellido']) && $_POST['apellido'] != null &&
       isset($_POST['nombre']) && $_POST['nombre'] != null
        && isset($_POST['fechanacimiento']) && $_POST['fechanacimiento'] != ""
         && isset($_POST['genero']) && $_POST['genero'] != ""
          && isset($_POST['ndocumento']) && $_POST['ndocumento'] != ""
           && isset($_POST['domicilio']) && $_POST['domicilio'] != ""
             && isset($_POST['tipodocumento']) && $_POST['tipodocumento'] != ""
              && isset($_POST['heladera']) && $_POST['heladera'] != ""
               && isset($_POST['electricidad']) && $_POST['electricidad'] != ""
                && isset($_POST['mascota']) && $_POST['mascota'] != ""
                 && isset($_POST['tipovivienda']) && $_POST['tipovivienda'] != ""
                  && isset($_POST['tipocalefaccion']) && $_POST['tipocalefaccion'] != ""
                   && isset($_POST['tipoagua']) && $_POST['tipoagua'] != ""  ){
                     PacienteController::getInstance()->altaPaciente($_POST['apellido'],$_POST['nombre'],
                     $_POST['fechanacimiento'],$_POST['genero'],$_POST['tipodocumento'],$_POST['ndocumento'],
                     $_POST['domicilio'],$_POST['telefono'],$_POST['obrasocial'],$_POST['heladera'],
                     $_POST['electricidad'],$_POST['mascota'],$_POST['tipovivienda'],$_POST['tipocalefaccion'],$_POST['tipoagua']);
    }else{
      BackendController::getInstance()->mensajeError("Por favor llenar los campos correctamente");
    }
    break;
    case 'editarPaciente':
      if (isset($_POST['apellido']) && $_POST['apellido'] != null &&
       isset($_POST['nombre']) && $_POST['nombre'] != null
        && isset($_POST['fechanacimiento']) && $_POST['fechanacimiento'] != ""
         && isset($_POST['genero']) && $_POST['genero'] != ""
          && isset($_POST['ndocumento']) && $_POST['ndocumento'] != ""
           && isset($_POST['domicilio']) && $_POST['domicilio'] != ""
             && isset($_POST['tipodocumento']) && $_POST['tipodocumento'] != ""
              && isset($_POST['heladera']) && $_POST['heladera'] != ""
               && isset($_POST['electricidad']) && $_POST['electricidad'] != ""
                && isset($_POST['mascota']) && $_POST['mascota'] != ""
                 && isset($_POST['tipovivienda']) && $_POST['tipovivienda'] != ""
                  && isset($_POST['tipocalefaccion']) && $_POST['tipocalefaccion'] != ""
                   && isset($_POST['tipoagua']) && $_POST['tipoagua'] != ""  ){
                          PacienteController::getInstance()->editarPaciente($_POST['idPaciente'],$_POST['apellido'],$_POST['nombre'],
                          $_POST['fechanacimiento'],$_POST['genero'],$_POST['tipodocumento'],$_POST['ndocumento'],
                          $_POST['domicilio'],$_POST['telefono'],$_POST['obrasocial'],$_POST['heladera'],
                          $_POST['electricidad'],$_POST['mascota'],$_POST['tipovivienda'],$_POST['tipocalefaccion'],$_POST['tipoagua']);
    }else{
        BackendController::getInstance()->mensajeError("Por favor llenar los campos correctamente");
    }
    break;
    case 'verPerfil':
    PacienteController::getInstance()->showAction($_GET['idDatosDemograficos'],$_GET['nombre'],$_GET['apellido']);
    break;
    case 'eliminarPaciente':
    PacienteController::getInstance()->destroyAction($_GET['idPaciente']);
    break;
    case "buscar":
    $aux3= $_GET['option'];
    if ($aux3 == "usuarios") {
      if (isset($_POST)) {
        $aux = $_REQUEST['busqueda'];
        if (isset($_GET['filtro'])) {
          $aux2 = $_GET['filtro'];
          header('location:index.php?action=listar&option='.$aux3.'&indice=1&filtro='.$aux2.'&busqueda='.$aux);
        }
        else{
          header('location:index.php?action=listar&option='.$aux3.'&indice=1&busqueda='.$aux);
        }
      }
      else {
        header('location:index.php?action=listar&option='.$aux3.'&indice=1');
      }
    }
    elseif ($aux3 == "pacientes") {
      $tipoBusqueda = $_POST["tipo-busqueda"];
      $busqueda = $_POST["busqueda"];
      header('location:index.php?action=listar&option='.$aux3.'&indice=1&busqueda='.$busqueda.'&tipo='.$tipoBusqueda);
    }
    break;
    case "filtrar":
    $aux3= $_GET['option'];
    if (isset($_POST)) {
      $aux = $_REQUEST['usuario-habilitado'];
      if (isset($_GET['busqueda'])) {
        $aux2 = $_GET['busqueda'];
        header('location:index.php?action=listar&option='.$aux3.'&indice=1&filtro='.$aux.'&busqueda='.$aux2);
      }
      else{
        header('location:index.php?action=listar&option='.$aux3.'&indice=1&filtro='.$aux);
      }
    }
    else {
      header('location:index.php?action=listar&option='.$aux3.'&indice=1');
    }
    break;
    case 'listar':
    if (isset($_GET['option']) and isset($_GET['indice'])) {
      switch ($_GET['option']) {
        case 'usuarios':
        if (modelUser::getInstance()->isAdministrator($_SESSION['idUser'])) {
          $array = array();
          if (isset($_GET['busqueda'])) {
            if (isset($_GET['filtro']) and $_GET['filtro'] != "todos") {
              $array = modelAdmin::getInstance()->getUsersLikeAndFiltered($_GET['busqueda'], $_GET['filtro']);
              $lista = AdminController::getInstance()->prepararPaginacion($array,$_GET['indice']);
              $lista['busqueda'] = $_GET['busqueda'];
              $lista['filtro'] = $_GET['filtro'];
            }
            else {
              $array = modelAdmin::getInstance()->getUsersLike($_GET['busqueda']);
              $lista = AdminController::getInstance()->prepararPaginacion($array,$_GET['indice']);
              $lista['busqueda'] = $_GET['busqueda'];
            }
          }
          else {
            if (isset($_GET['filtro'])) {
              $array = modelAdmin::getInstance()->getUsersFiltered($_GET['filtro']);
              $lista = AdminController::getInstance()->prepararPaginacion($array,$_GET['indice']);
              $lista['filtro'] = $_GET['filtro'];
            }
            else {
              $array = modelAdmin::getInstance()->getUsers();
              $lista = AdminController::getInstance()->prepararPaginacion($array,$_GET['indice']);
            }
          }
          $lista['option'] = $_GET['option'];
          $array = array();
          $array['session'] = true;
          $array['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
          $array['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
          $array['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
          renderizar('templates/','header',$array);
          renderizar('templates/','listTableView',array('paginas' => $lista ));
        }
        break;
        case 'pacientes':
        if (AppController::checkPermissions('pacienteIndex')){
          $array = array();
          if ((isset($_GET['busqueda'])) && (isset($_GET['tipo']))) {
              $array = modelPaciente::getInstance()->getPacientesLike($_GET['busqueda'], $_GET['tipo']);
              $lista = AdminController::getInstance()->prepararPaginacion($array,$_GET['indice']);
              $lista['busqueda'] = $_GET['busqueda'];
              $lista['tipo'] = $_GET['tipo'];
            }
            else {
              $array = modelPaciente::getInstance()->getPacientes();
              $lista = AdminController::getInstance()->prepararPaginacion($array,$_GET['indice']);
            }
          $lista['option'] = $_GET['option'];
          $lista['isPediatra'] = modelUser::getInstance()->isPediatra($_SESSION['idUser']);
          $lista['isAdmin'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
          $array = array();
          $array['option'] = $_GET['option'];
          $array['session'] = true;
          $array['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
          $array['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
          $array['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
          renderizar('templates/','header',$array);
          renderizar('templates/','listTableView',array('paginas' => $lista ));
        }
        break;
        case 'historia':
        if (modelUser::getInstance()->isPediatra($_SESSION['idUser']) | modelUser::getInstance()->isAdministrator($_SESSION['idUser']) ){
          $array = modelPaciente::getInstance()->getHistoria($_GET['paciente']);
          $lista = modelPaciente::getInstance()->getNombrePaciente($_GET['paciente']);
          $lista = AdminController::getInstance()->prepararPaginacion($array,$_GET['indice']);
          $lista['option'] = $_GET['option'];
          $array['option'] = $_GET['option'];
          $array['session'] = true;
          $array['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
          $array['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
          $array['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
          $lista['nombrePaciente'] = modelPaciente::getInstance()->getNombrePaciente($_GET['paciente']);
          $lista['isAdmin'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
          $lista['isPediatra'] = modelUser::getInstance()->isPediatra($_SESSION['idUser']);
          $lista['pediatraNombres'] = modelUser::getInstance()->getNombresPediatras();
          $lista['idPaciente'] = $_GET['paciente'];
          renderizar('templates/','header',$array);
          renderizar('templates/','listTableView',array('paginas' => $lista ));
        }
        break;
      }
    }
    break;
    case "addRevision":
    $array = array();
    $array['session'] = true;
    $array['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
    $array['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
    $array['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
    $array['idPaciente'] = $_GET['idPaciente'];
    PacienteController::getInstance()->mostrarFormRevisionNew($array);
    break;

    case "showRevision":
    $array = array();
    $array['session'] = true;
    $array['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
    $array['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
    $array['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
    $array['idPaciente'] = $_GET['idPaciente'];
    $array['idPediatra'] = $_GET['idPediatra'];
    $array['idRevision'] = $_GET['idRevision'];
    PacienteController::getInstance()->mostrarRevision($array);
    break;
    case 'agregarRevision':
    if ( isset($_POST['fecha']) && $_POST['fecha'] != ""
      && isset($_POST['peso']) && $_POST['peso'] != ""
       && isset($_POST['observacionesVacunas']) && $_POST['observacionesVacunas'] != ""
        && isset($_POST['observacionesMaduracion']) && $_POST['observacionesMaduracion'] != ""
         && isset($_POST['observacionesExamenFisico']) && $_POST['observacionesExamenFisico']  != ""){
           if (isset($_POST['vacunas'])) {
             $vacunas = 1;
           } else {
             $vacunas = 0;
           }
           if (isset($_POST['maduracion'])) {
             $maduracion = 1;
           }
           else {
             $maduracion = 0;
           }
           if (isset($_POST['examenFisico'])) {
             $exFisico = 1;
           }
           else {
             $exFisico = 0;
           }
            PacienteController::getInstance()->agregarRevision($_POST['fecha'],$_POST['peso'],$vacunas,$_POST['observacionesVacunas'],
            $maduracion,$_POST['observacionesMaduracion'],$exFisico,$_POST['observacionesExamenFisico'],
            $_POST['pc'],$_POST['ppc'],$_POST['talla'],$_POST['alimentacion'], $_POST['observacionesGenerales'],$_POST['idPaciente'],$_SESSION['idUser']);
          }
          else{
              BackendController::getInstance()->mensajeError("Por favor llenar los campos correctamente");
          }
    break;
    case 'alta_usuario':
    if ( isset($_POST['email']) && $_POST['email'] != ""
      && isset($_POST['user_name']) && $_POST['user_name'] != ""
       && isset($_POST['name']) && $_POST['name'] != ""
        && isset($_POST['apellido']) && $_POST['apellido'] != ""
         && isset($_POST['password']) && $_POST['apellido']  != ""
          && isset($_POST['roles']) && $_POST['roles'] != ""  ){
            AdminController::getInstance()->agregarUsuario($_POST['email'],$_POST['user_name'],$_POST['name'],$_POST['apellido'],$_POST['password'],$_POST['roles']);
          }
          else{
              BackendController::getInstance()->mensajeError("Por favor llenar los campos correctamente");
          }
    break;
    case "adduser":
    AdminController::getInstance()->mostrarFormRegistro();
    break;
    case 'alta_usuario':
    if ( isset($_POST['email']) && $_POST['email'] != ""
      && isset($_POST['user_name']) && $_POST['user_name'] != ""
       && isset($_POST['name']) && $_POST['name'] != ""
        && isset($_POST['apellido']) && $_POST['apellido'] != ""
         && isset($_POST['password']) && $_POST['apellido']  != ""
          && isset($_POST['roles']) && $_POST['roles'] != ""  ){
            AdminController::getInstance()->agregarUsuario($_POST['email'],$_POST['user_name'],$_POST['name'],$_POST['apellido'],$_POST['password'],$_POST['roles']);
          }
          else{
              BackendController::getInstance()->mensajeError("Por favor llenar los campos correctamente");
          }
    break;
    case "edit_user":
    $mail = $_GET['email'];
    AdminController::getInstance()->mostrarFormEditar($mail);
    break;
    case 'confirmar_edit_user':
    if (isset($_POST['email']) && ($_POST['email'] != "")
        && isset($_POST['name']) && ($_POST['name'] != "")
         && isset($_POST['apellido']) && ($_POST['apellido'] != "")
          && isset($_POST['roles'])
           && isset($_POST['id']) && ($_POST['id'] != "") ){
      AdminController::getInstance()->editarUsuario($_POST['email'],$_POST['name'],$_POST['apellido'],$_POST['roles'], $_POST['id']);
    }
    break;
    case "configuraciones":
      AdminController::getInstance()->configuracion();
    break;
    case 'bloquea_usuario':
    if (isset($_POST['usuario']) && $_POST['usuario'] != ""){
      AdminController::getInstance()->bloquearUsuario($_POST['usuario']);
    }
    break;
    case 'activa_usuario':
    if (isset($_POST['usuario']) && $_POST['usuario'] != ""){
      AdminController::getInstance()->activarUsuario($_POST['usuario']);
    }
    break;
    case 'elimina_usuario':
    if (isset($_POST['usuario']) && $_POST['usuario'] != ""){
      AdminController::getInstance()->eliminarUsuario($_POST['usuario']);
    }
    break;
    case 'elimina_revision':
    if (isset($_POST['revision']) && $_POST['revision'] != ""){
      AdminController::getInstance()->eliminarRevision($_POST['revision']);
    }
    break;
    case 'nuevaConfiguracion':
    if ( (isset($_POST['titulo'])) && (($_POST['titulo'])!="")
      && (isset($_POST['habilitado'])) && (($_POST['habilitado'])!="")
        && (isset($_POST['cantidad_listado'])) && (($_POST['cantidad_listado'])!="")
          && (isset($_POST['email'])) && (($_POST['email'])!="")
            && (isset($_POST['descripcionHospital'])) && (($_POST['descripcionHospital'])!="")
              && (isset($_POST['descripcionGuardia'])) && (($_POST['descripcionGuardia'])!="")
                && (isset($_POST['descripcionEspecialidades'])) && (($_POST['descripcionEspecialidades'])!="") )
    {
        $titulo = $_POST['titulo'];
        $habilitado = $_POST['habilitado'];
        $cantidad_listado = $_POST['cantidad_listado'];
        $email = $_POST['email'];
        $infoHospital = $_POST['descripcionHospital'];
        $infoGuardia = $_POST['descripcionGuardia'];
        $infoEspecialidades = $_POST['descripcionEspecialidades'];
        AdminController::getInstance()->altaConfiguracion($titulo,$habilitado,$cantidad_listado,$email,$infoHospital,$infoGuardia,$infoEspecialidades);
    }
    break;
    case 'verCurvaCrecimientoPeso':
      if (isset($_GET['paciente'])) {
        $datos = array();
        $datos['datos'] = modelPaciente::getInstance()->getHistoriaPesos($_GET['paciente']);
        $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
        $datos['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
        $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
        $datos['session'] = true;
        if ((modelPaciente::getInstance()->getGenero($_GET['paciente'])['genero']) == 'masculino')
          renderizar('templates/','graficoPesoNiños',$datos);
        else
          renderizar('templates/','graficoPesoNiñas',$datos);
      }
      break;
      case 'verCurvaCrecimientoTalla':
        if (isset($_GET['paciente'])) {
          $datos = array();
          $datos['datos'] = modelPaciente::getInstance()->getHistoriaTallas($_GET['paciente']);
          $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
          $datos['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
          $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
          $datos['session'] = true;
          if ((modelPaciente::getInstance()->getGenero($_GET['paciente'])['genero']) == 'masculino')
            renderizar('templates/','graficoTallaNiños',$datos);
          else
            renderizar('templates/','graficoTallaNiñas',$datos);
        }
        break;
      case 'verCurvaPPC':
        if (isset($_GET['paciente'])){
          $datos['datos'] = modelPaciente::getInstance()->getHistoriaPPC($_GET['paciente']);
          $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
          $datos['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
          $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
          $datos['session'] = true;
          if ((modelPaciente::getInstance()->getGenero($_GET['paciente'])['genero']) == 'masculino'){
            renderizar('templates/','graficoPerimetroCefalicoNiños',$datos);
          }else{
            renderizar('templates/','graficoPerimetroCefalicoNiñas',$datos);
          }
        }
        break;
      case 'verGraficoTipoVivienda':
          $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
          $datos['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
          $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
          $datos['session'] = true;
          $datos['tipos'] = modelApiReferencias::getInstance()->getAllTypesOfHousing();
          foreach ($datos['tipos'] as $key => $value) {
            $datos['tipos'][$key]['cantidad']=modelDemograficos::getInstance()->cantidadViviendasTipo($datos['tipos'][$key]['id']);
          }
          renderizar('templates/','graficoTortaTipoVivienda',$datos);
        break;
        case 'clienteTelegram':
          ClienteTelegram::getInstance()->execute();
          break;
        // case 'apiTurnos':
        //   switch ($_GET['option']) {
        //     case 'reservar':
        //       return Requests::get('https://grupo8.proyecto2017.linti.unlp.edu.ar/ApiTurnos/reservar&dni='.$dni.'&fecha='.$fecha.'&hora='.$hora, $headers, $options);
        //       break;
        //     case 'turnos':
        //       return Requests::get('https://grupo8.proyecto2017.linti.unlp.edu.ar/ApiTurnos/turnos&fecha='.$fecha, $headers, $options)
        //       break;
        //   }
        //   break;
        //no funciona así...
  }
}else{
  $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
  if(isset($_SESSION['email'])){
    $datos['session'] = true;
    $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
    $datos['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
    $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
  }
  else {
    $datos['session'] = false;
  }
  if ($datos['infoHospital']['habilitado'] == "si"){
    renderizar('templates/','indexView',$datos);
  }
  else{
    renderizar('templates/','mantenimientoView',$datos);
  }
}
?>
