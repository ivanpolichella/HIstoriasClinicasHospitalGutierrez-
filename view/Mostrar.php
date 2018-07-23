<?php

class Mostrar extends TwigView {


  public function show($opc){
      echo self::getTwig()->render($opc.'_view.twig.html', array('datos' => null ));
  }

}
 ?>
