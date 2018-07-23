<?php
require_once("model/PDOConnection.php");


class modelPaciente{
  private static $instance;

  public static function getInstance() {

      if (!isset(self::$instance)) {
          self::$instance = new self();
      }

      return self::$instance;
  }

  private function __construct() {
  }

  private function consulta($query){
    $model = new PDOConnection;
    $connection = $model->getConnection();
    $stmt = $connection->prepare($query);
    if ($stmt) {
      $stmt->execute();
      $resultado = $stmt->fetchAll();
         return ($resultado);
    }
  }
  public function getTipoDoc()
  {
    $query="SELECT * FROM tipoDocumento";
    return $this->consulta($query);
  }

  public function getPacientesLike($busqueda, $tipo){
    $query = "SELECT idPaciente,apellido,nombre,domicilio,tel,DATE_FORMAT(FechaNacimiento, '%d/%m/%Y')as fechaNacimiento,genero,datosDemograficosId,obraSocialId,tipoDocId,numero FROM paciente WHERE $tipo LIKE '%$busqueda%' ";
    return $this->consulta($query);
  }

  public function getPacientesFiltered($filtro){
    if ($filtro == "activos") {
      $query = "SELECT idPaciente,apellido,nombre,domicilio,tel,DATE_FORMAT(FechaNacimiento, '%d/%m/%Y')as fechaNacimiento,genero,datosDemograficosId,obraSocialId,tipoDocId,numero FROM paciente WHERE activo = 0";
    }
    else {
      $query = "SELECT idPaciente,apellido,nombre,domicilio,tel,DATE_FORMAT(FechaNacimiento, '%d/%m/%Y')as fechaNacimiento,genero,datosDemograficosId,obraSocialId,tipoDocId,numero FROM paciente WHERE activo = 1";
    }
    return $this->consulta($query);
  }

  public function getPacientesLikeAndFiltered($busqueda,$filtro){
    if ($filtro = "activos") {
      $query = "SELECT idPaciente,apellido,nombre,domicilio,tel,DATE_FORMAT(FechaNacimiento, '%d/%m/%Y')as fechaNacimiento,genero,datosDemograficosId,obraSocialId,tipoDocId,numero FROM paciente WHERE nombre LIKE '%$busqueda%' AND activo = 0 ";
    }
    else {
      $query = "SELECT idPaciente,apellido,nombre,domicilio,tel,DATE_FORMAT(FechaNacimiento, '%d/%m/%Y')as fechaNacimiento,genero,datosDemograficosId,obraSocialId,tipoDocId,numero FROM paciente WHERE nombre LIKE '%$busqueda%' AND activo = 1 ";
    }
    return $this->consulta($query);
  }


  public function getPacientes(){
    $query = "SELECT idPaciente,apellido,nombre,domicilio,tel,DATE_FORMAT(FechaNacimiento, '%d/%m/%Y')as fechaNacimiento,genero,datosDemograficosId,obraSocialId,tipoDocId,numero FROM paciente";
    return $this->consulta($query);
  }

  public function getHistoria($id){
    $query = "SELECT * FROM controlSalud WHERE pacienteId = $id ORDER BY fecha DESC";
    return $this->consulta($query);
  }

  public function getRevision($id)
  {
    $query = "SELECT * FROM controlSalud WHERE idControlSalud = $id";
    return $this->consulta($query);
  }


  public function getObraSocial()
  {
    $query="SELECT * FROM obraSocial";
    return $this->consulta($query);
  }


    public function getNombrePaciente($id)
    {
      $query="SELECT nombre,apellido FROM paciente WHERE idPaciente = $id";
      $model = new PDOConnection;
      $connection = $model->getConnection();
      $stmt = $connection->prepare($query);
      if ($stmt) {
        $stmt->execute();
        $resultado = $stmt->fetchAll();
           return ($resultado[0]);
    }
  }

  public function calcularEdad($fecha, $nacimiento) {
    //fecha actual
    $dia=date("j", strtotime($fecha));
    $mes=date("n", strtotime($fecha));
    $ano=date("Y", strtotime($fecha));
    //fecha de nacimiento
    $dianaz=date("j", strtotime($nacimiento));
    $mesnaz=date("n", strtotime($nacimiento));
    $anonaz=date("Y", strtotime($nacimiento));
//si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
   if (($mesnaz == $mes) && ($dianaz > $dia)) {
       $ano=($ano-1); }
//si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
   if ($mesnaz > $mes) {
       $ano=($ano-1);}
 $edad=($ano-$anonaz);
 return($edad);
}

  public function getFechaNacimiento($id)
  {
    $query="SELECT DATE_FORMAT(fechaNacimiento,'%d-%m-%y')as fechanacimiento FROM paciente WHERE idPaciente = $id";
    $model = new PDOConnection;
    $connection = $model->getConnection();
    $stmt = $connection->prepare($query);
    if ($stmt) {
      $stmt->execute();
      $resultado = $stmt->fetch();
         return ($resultado);
  }
}
  public function updatePaciente($idPaciente,$apellido,$nombre,$fechanacimiento,$genero,$tipodocumento,$ndocumento,
    $domicilio,$telefono,$obrasocial,$heladera,$electricidad,$mascota,$tipovivienda,$tipocalefaccion,$tipoagua)
  {
    $model = new PDOConnection;
    $connection = $model->getConnection();
    $connection->beginTransaction();
    $queryDemograficos = "UPDATE datosDemograficos SET mascota='$mascota',tipoViviendaId='$tipovivienda',tipoCalefaccionId='$tipocalefaccion',
      tipoAguaId='$tipoagua',heladera='$heladera',electricidad='$electricidad'";

    $query = "UPDATE paciente SET apellido='$apellido',nombre='$nombre',domicilio='$domicilio',
      tel='$telefono',fechaNacimiento='$fechanacimiento',genero='$genero',obraSocialId='$obrasocial',
      tipoDocId='$tipodocumento',numero='$ndocumento'";

    $stmt = $connection->prepare($query);
    $stmt->execute();
    $stmt2 = $connection->prepare($queryDemograficos);
    $stmt2->execute();
    $connection->commit();
  }

  function altaRevision($fecha,$peso,$vacunas,$observacionesVacunas,
  $maduracion,$observacionesMaduracion,$examenFisico,$observacionesExamenFisico,
  $pc,$ppc,$talla,$alimentacion,$observacionesGenerales,$idPaciente,$idUser){
    $query = "INSERT INTO controlSalud (fecha, peso, vacunasCompletas, observacionesVacuna, maduracionAcorde, observacionesMaduracion, exFisicoNormal,
      exFisicoObservaciones, pc, ppc, talla, alimentacion, observacionesGenerales, pacienteId, userId)
       VALUES ('$fecha','$peso','$vacunas', '$observacionesVacunas','$maduracion','$observacionesMaduracion' ,'$examenFisico','$observacionesExamenFisico',
         '$pc','$ppc','$talla','$alimentacion', '$observacionesGenerales', '$idPaciente','$idUser')";
    $this->consulta($query);
  }

  function altaPaciente($apellido,$nombre,$fechanacimiento,$genero,$tipodocumento,$ndocumento,$domicilio,$telefono,$obrasocial,
  $heladera,$electricidad,$mascota,$tipovivienda,$tipocalefaccion,$tipoagua)
  {
    $model = new PDOConnection;
    $connection = $model->getConnection();
    $connection->beginTransaction();
    $queryDemograficos = "INSERT INTO datosDemograficos (idDatosDemograficos,mascota,tipoViviendaId,tipoCalefaccionId,tipoAguaId,heladera,electricidad)
      VALUES (NULL,$mascota,$tipovivienda,$tipocalefaccion,$tipoagua,$heladera,$electricidad)";
    $stmt = $connection->prepare($queryDemograficos);
    $stmt->execute();
    $ultimos_datos = $connection->lastInsertId();

    $query="INSERT INTO paciente (idPaciente,apellido,nombre,fechaNacimiento,genero,tipoDocId,numero,domicilio,tel,obraSocialId,datosDemograficosId)
      VALUES (NULL,'$apellido','$nombre','$fechanacimiento','$genero','$tipodocumento','$ndocumento','$domicilio','$telefono','$obrasocial','$ultimos_datos')";

    $stmt2 = $connection->prepare($query);
    $stmt2->execute();
    $connection->commit();
  }

  public function pacienteDestroy($idPaciente)
  {
    $model = new PDOConnection;
    $connection = $model->getConnection();
    $connection->beginTransaction();
    $idDatosDemograficos = $this->getDatoDemograficoId($idPaciente);
    $queryDemograficos = "DELETE FROM datosDemograficos WHERE idDatosDemograficos='$idDatosDemograficos'";
    $query = "DELETE FROM paciente WHERE paciente.idPaciente='$idPaciente'";
    $stmt = $connection->prepare($queryDemograficos);
    $stmt->execute();
    $stmt2 = $connection->prepare($query);
    $stmt2->execute();
    $connection->commit();
  }

  public function getDatoDemograficoId($idPaciente)
  {
    $query="SELECT datosDemograficosId FROM paciente WHERE idPaciente='$idPaciente'";
    return $this->consulta($query)[0]['datosDemograficosId'];
  }

  public function getPaciente($idPaciente)
  {
    $query="SELECT * FROM paciente WHERE idPaciente='$idPaciente'";
    return $this->consulta($query)[0];
  }

  public function getHistoriaPesos($idPaciente){
      $query = "SELECT peso FROM controlSalud WHERE pacienteId = '$idPaciente' ";
      return $this->consulta($query);
  }

  public function getHistoriaPPC($idPaciente)
  {
    $query = "SELECT ppc FROM controlSalud WHERE pacienteId = '$idPaciente' ";
    return $this->consulta($query);
  }

  public function getHistoriaTallas($idPaciente){
      $query = "SELECT talla FROM controlSalud WHERE pacienteId = '$idPaciente' ";
      return $this->consulta($query);
  }
  public function getGenero($idPaciente)
  {
    $query = "SELECT genero FROM paciente WHERE idPaciente = '$idPaciente' ";
    return $this->consulta($query)[0];
  }

}
?>
