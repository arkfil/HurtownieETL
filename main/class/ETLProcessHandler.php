<?php

class ETLProcessHandler{


  public static function start($productId){
    $ex = new ExtractHandler;
    $tr = new TransformHandler;

    $data = $ex->extractData($productId);
    $productObj = $tr->transformData($data,$productId);


    // TO DO
    // LOAD DATA!!!!

    return $productObj;


  }

}



 ?>
