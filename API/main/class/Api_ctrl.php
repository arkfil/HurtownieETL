<?php
class Api_ctrl{


  public static function createView($viewName){
    // api.php
    require_once("./main/api/$viewName".".php");


  }


}


?>
