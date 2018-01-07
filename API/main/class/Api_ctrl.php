<?php

/**
 * Klasa Api_ctrl która robi cos. Nie wiem ale sie domyslam.
 */
class Api_ctrl{

/**
 * metoda createView klasy Api_ctrl
 */
  public static function createView($viewName){
    // api.php
    require_once("./main/api/$viewName".".php");


  }


}


?>
