<?php

require_once("./model/modelApiReferencias.php");
require_once("AppController.php");
require_once("view/Render.php");
require_once("model/modelPaciente.php");
require_once("model/modelDemograficos.php");

if(!isset($_SESSION)){
  session_start();
}


class PacienteController{
  private static $instance;


  public static function getInstance(){
    if (!isset(self::$instance)){
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function newAction(){
    if(AppController::checkPermissions('pacienteNew')){
      $datos['obrasocial'] = modelApiReferencias::getInstance()->getAllTypesOfObraSocial();
      $datos['tipodocumento'] = modelApiReferencias::getInstance()->getAllTypesOfDocuments();
      $datos['tipocalefaccion'] = modelApiReferencias::getInstance()->getAllTypesOfHeating();
      $datos['tipoagua'] = modelApiReferencias::getInstance()->getAllTypesOfWater();
      $datos['tipovivienda'] = modelApiReferencias::getInstance()->getAllTypesOfHousing();
      $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
      $datos['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
      $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
      $datos['session'] = true;
      renderizar('templates/','altaPacienteView',$datos);
    }
    else{
      header("location:index.php");
    }
  }

  public function updateAction($idPaciente,$idDatosDemograficos){
    if (AppController::checkPermissions('pacienteUpdate')){
      $paciente = modelPaciente::getInstance()->getPaciente($idPaciente);
      $datosDemograficos = modelDemograficos::getInstance()->getDatosDemograficos($idDatosDemograficos);
      $datos = array('paciente' => $paciente, 'datosDemograficos' => $datosDemograficos);
      $obrasocial=modelPaciente::getInstance()->getObraSocial();
      $datos['obrasocial'] = modelApiReferencias::getInstance()->getAllTypesOfObraSocial();
      $datos['tipodocumento'] = modelApiReferencias::getInstance()->getAllTypesOfDocuments();
      $datos['tipocalefaccion'] = modelApiReferencias::getInstance()->getAllTypesOfHeating();
      $datos['tipoagua'] = modelApiReferencias::getInstance()->getAllTypesOfWater();
      $datos['tipovivienda'] = modelApiReferencias::getInstance()->getAllTypesOfHousing();
      $datos['session'] = true;
      $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
      $datos['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
      $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
      renderizar('templates/','updatePaciente',$datos);
    }
    else{
      header("location:index.php");
    }
  }

  public function editarPaciente($idPaciente,$apellido,$nombre,$fechanacimiento,$genero,$tipodocumento,$ndocumento,
  $domicilio,$telefono,$obrasocial,$heladera,$electricidad,$mascota,$tipovivienda,$tipocalefaccion,$tipoagua)
  {
    if(AppController::checkPermissions('pacienteUpdate')){
        $apellido = htmlentities($apellido);
        $nombre = htmlentities($nombre);
        $fechanacimiento = htmlentities($fechanacimiento);
        $genero = htmlentities($genero);
        $tipodocumento = htmlentities($tipodocumento);
        $ndocumento = htmlentities($ndocumento);
        $domicilio = htmlentities($domicilio);
        $telefono = htmlentities($telefono);
        $obrasocial = htmlentities($obrasocial);
        $heladera = htmlentities($heladera);
        $electricidad = htmlentities($electricidad);
        $mascota = htmlentities($mascota);
        $tipovivienda = htmlentities($tipovivienda);
        $tipocalefaccion = htmlentities($tipocalefaccion);
        $tipoagua = htmlentities($tipoagua);
        modelPaciente::getInstance()->updatePaciente($idPaciente,$apellido,$nombre,$fechanacimiento,$genero,$tipodocumento,$ndocumento,
          $domicilio,$telefono,$obrasocial,$heladera,$electricidad,$mascota,$tipovivienda,$tipocalefaccion,$tipoagua);
      header("location:index.php?action=listar&option=pacientes&indice=1");

    }
  }
  public function showAction($datosDemograficosId,$nombre,$apellido){
    if (AppController::checkPermissions('pacienteShow')) {
      $datos = array();
      $datos['permissions'] = modelUser::getInstance()->getAllPermissionsOfUser($_SESSION['idUser']);
      $datos['isAdm'] = modelUser::getInstance()->isAdministrator($_SESSION['idUser']);
      $datos['infoHospital'] = modelSettings::getInstance()->getInfoHospital();
      $datosDemograficos = modelDemograficos::getInstance()->getDatosDemograficos($datosDemograficosId);
      $datos['tipoVivienda'] = modelApiReferencias::getInstance()->getTipoVivienda($datosDemograficos['tipoViviendaId']);
      $datos['tipoCalefaccion'] = modelApiReferencias::getInstance()->getTipoCalefaccion($datosDemograficos['tipoCalefaccionId']);
      $datos['tipoAgua'] = modelApiReferencias::getInstance()->getTipoAgua($datosDemograficos['tipoAguaId']);
      //$datos['tipoCalefaccion']['nombre'];
      $datos['session'] = TRUE;
      $datos['nombre'] = $nombre;
      $datos['apellido'] = $apellido;
      $datos['datosDemograficos'] = $datosDemograficos;
      renderizar('templates/','perfilPaciente',$datos);
    }else{
      header("location:index.php");
    }
  }

  public function destroyAction($idPaciente){
    if (AppController::checkPermissions('pacienteDestroy')) {
      modelPaciente::getInstance()->pacienteDestroy($idPaciente);
      header("location:index.php?action=listar&option=pacientes&indice=1");
    }else{
      header("location:index.php");
    }
  }

 //ESTO NO SE PUEDE HACER PORQUE NO LE MANDAN LOS DATOS DE LA VISTA
 public function noTienePermiso(){
      $datos = array('error' => "no tenes permisos para esta acción");
      renderizar('templates/','indexView',$datos);
  }

  public function mostrarFormRevisionNew($datos){
       renderizar('templates/','pacienteRevisionNew',$datos);
   }

   public function mostrarRevision($datos){
        $revision= modelPaciente::getInstance()->getRevision($datos['idRevision']);
        $revision[0]['pacienteNombre'] = modelPaciente::getInstance()->getNombrePaciente($datos['idPaciente']);
        $revision[0]['pediatraNombre'] = modelUser::getInstance()->getNombre($datos['idPediatra']);
        $fechanacimiento = modelPaciente::getInstance()->getFechaNacimiento($datos['idPaciente']);
        $fecha=$revision[0]['fecha'];
        $fecha=date_create();
        $fecha=date_format($fecha,'d-m-y');
        $revision[0]['fecha']=$fecha;
        $revision[0]['edad'] = $fechanacimiento[0];
        renderizar('templates/','header',$datos);
        renderizar('templates/','pacienteRevisionShow',$revision[0]);
    }

  public function agregarRevision($fecha,$peso,$vacunas,$observacionesVacunas,
  $maduracion,$observacionesMaduracion,$examenFisico,$observacionesExamenFisico,
  $pc,$ppc,$talla,$alimentacion,$observacionesGenerales,$idPaciente,$idUSer){
    $fechaAux=htmlentities($fecha);
    $pesoAux=htmlentities($peso);
    $vacunasAux=htmlentities($vacunas);
    $observacionesVacunasAux=htmlentities($observacionesVacunas);
    $maduracionAux=htmlentities($maduracion);
    $observacionesMaduracionAux=htmlentities($observacionesMaduracion);
    $examenFisicoAux=htmlentities($examenFisico);
    $observacionesExamenFisicoAux=htmlentities($observacionesExamenFisico);
    $pcAux=htmlentities($pc);
    $ppcAux=htmlentities($ppc);
    $tallaAux=htmlentities($talla);
    $alimentacionAux=htmlentities($alimentacion);
    $observacionesGeneralesAux=htmlentities($observacionesGenerales);
    $idPacienteAux=htmlentities($idPaciente);
    $idUserAux=htmlentities($idUSer);
    modelPaciente::getInstance()->altaRevision($fechaAux,$pesoAux,$vacunasAux,$observacionesVacunasAux,
    $maduracionAux,$observacionesMaduracionAux,$examenFisicoAux,$observacionesExamenFisicoAux,
    $pcAux,$ppcAux,$tallaAux,$alimentacionAux,$observacionesGeneralesAux,$idPacienteAux,$idUserAux);
    $datos = array('error' => "Se agregó la visita al sistema");
    header('location:index.php?action=listar&option=historia&paciente='.$idPaciente.'&indice=1');
  }

  public function altaPaciente($apellido,$nombre,$fechanacimiento,$genero,$tipodocumento,$ndocumento,$domicilio,$telefono,$obrasocial,
  $heladera,$electricidad,$mascota,$tipovivienda,$tipocalefaccion,$tipoagua){
    $ape = htmlentities($apellido);
    $nomb = htmlentities($nombre);
    $fecha = htmlentities($fechanacimiento);
    $gene = htmlentities($genero);
    $tipodoc = htmlentities($tipodocumento);
    $ndoc = htmlentities($ndocumento);
    $dom = htmlentities($domicilio);
    $telef = htmlentities($telefono);
    $obrasoc = htmlentities($obrasocial);
    $helad = htmlentities($heladera);
    $electric = htmlentities($electricidad);
    $mascota = htmlentities($mascota);
    $tipoviv = htmlentities($tipovivienda);
    $tipocalef = htmlentities($tipocalefaccion);
    $tipoa = htmlentities($tipoagua);
    if (AppController::checkPermissions('pacienteNew')){
      modelPaciente::getInstance()->altaPaciente($ape,$nomb,$fecha,$gene,$tipodoc,$ndoc,$dom,$telef,$obrasoc,
      $helad,$electric,$mascota,$tipoviv,$tipocalef,$tipoa);
      $datos = array('error' => "Se agregó el paciente al sistema");
      header('location:index.php');
    }else
      $this->noTienePermiso();
  }
}
?>
