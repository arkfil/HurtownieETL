<?php

class ETLProcessHandler{


  public static function start($productId){
    $ex = new ExtractHandler;
    $tr = new TransformHandler;
    $ld = new LoadHandler;

    $data = $ex->extractData($productId);
    $productObj = $tr->transformData($data,$productId);
    $ld->loadData($productObj);


    return $productObj;


  }

}



 ?>
