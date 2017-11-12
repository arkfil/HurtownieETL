<?php

require_once('./routing/Route.php');

function __autoload($class_name) {
  if(file_exists('./main/'.$class_name.'.php')){
    require_once './main/'.$class_name.'.php';
  }
}

require_once('./routing/Routes.php');

 ?>
