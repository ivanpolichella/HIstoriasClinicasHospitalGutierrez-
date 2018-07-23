<?php

function renderizar($template,$view,$variable){
  require_once 'Twig-1.16.2/lib/Twig/Autoloader.php';
  Twig_Autoloader::register();
  $loader = new Twig_Loader_Filesystem($template);
  $twig = new Twig_Environment($loader, array());
  $pathView= "$view.twig.html";
  $template = $twig->loadTemplate( $pathView );
  $template->display($variable);
}
