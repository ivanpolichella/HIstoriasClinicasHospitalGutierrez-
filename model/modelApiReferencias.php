<?php

require_once("./vendor/Requests/library/Requests.php");

Requests::register_autoloader();

class modelApiReferencias{
  private static $instance;


  public static function getInstance(){
    if (!isset(self::$instance)){
      self::$instance = new self();
    }
    return self::$instance;
  }

    public function getAllTypesOfDocuments(){
      // Asignación de headers
      $headers = array('Accept' => 'application/json');

      // Credenciales (si requiere autenticación)
      $options = array();
      #$options = array('auth' => array('user', 'pass'));

      // Ejecución de la consulta
      $collection_respose = Requests::get('https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-documento', $headers, $options);

      //var_dump($response->status_code);
      // int(200)

      if ($collection_respose->status_code == 200){
        //var_dump($response->headers['content-type']);
        // string(31) "application/json; charset=utf-8"

        //var_dump($response->body);
        // string(xxxx) "[...]"

        // Mapeos Simples
        // Arreglo de objetos
        //var_dump(json_decode($collection_respose->body));
        // Arreglo de arreglos
        return(json_decode($collection_respose->body, true));
       }
     }

     public function getAllTypesOfHousing(){
       // Asignación de headers
       $headers = array('Accept' => 'application/json');
       $options = array();
       $collection_respose = Requests::get('https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-vivienda', $headers, $options);
       if ($collection_respose->status_code == 200){
         return(json_decode($collection_respose->body, true));
        }
      }

      public function getTipoVivienda($id)
      {
        $headers = array('Accept' => 'application/json');
        $options = array();
        $collection_respose = Requests::get('https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-vivienda/'.$id, $headers, $options);
        if ($collection_respose->status_code == 200){
          return(json_decode($collection_respose->body, true));
         }
      }

      public function getAllTypesOfHeating(){
        // Asignación de headers
        $headers = array('Accept' => 'application/json');
        $options = array();
        $collection_respose = Requests::get('https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-calefaccion', $headers, $options);
        if ($collection_respose->status_code == 200){
          return(json_decode($collection_respose->body, true));
         }
       }

       public function getTipoCalefaccion($id)
       {
         $headers = array('Accept' => 'application/json');
         $options = array();
         $collection_respose = Requests::get('https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-calefaccion/'.$id, $headers, $options);
         if ($collection_respose->status_code == 200){
           return(json_decode($collection_respose->body, true));
          }
       }

       public function getAllTypesOfWater(){
         // Asignación de headers
         $headers = array('Accept' => 'application/json');
         $options = array();
         $collection_respose = Requests::get('https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-agua', $headers, $options);
         if ($collection_respose->status_code == 200){
           return(json_decode($collection_respose->body, true));
          }
        }

        public function getTipoAgua($id)
        {
          $headers = array('Accept' => 'application/json');
          $options = array();
          $collection_respose = Requests::get('https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-agua/'.$id, $headers, $options);
          if ($collection_respose->status_code == 200){
            return(json_decode($collection_respose->body, true));
           }
        }



        public function getAllTypesOfObraSocial(){
          // Asignación de headers
          $headers = array('Accept' => 'application/json');
          $options = array();
          $collection_respose = Requests::get('https://api-referencias.proyecto2017.linti.unlp.edu.ar/obra-social', $headers, $options);
          if ($collection_respose->status_code == 200){
            return(json_decode($collection_respose->body, true));
           }
         }
}
 ?>
