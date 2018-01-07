<?php
/**
 * Klasa do obs³ugi ca³ego procesu ETL
 */
class ETLProcessHandler{

/**
 * Metoda do uruchomienia procesu ETL
 * @param $productId Identyfikator produktu
 * @return Obiekt typu Product
 */
  public static function start($productId){
    $ex = new ExtractHandler;
    $tr = new TransformHandler;
    $ld = new LoadHandler;

    $data = $ex->extractData($productId);
    $productObj = $tr->transformData($data,$productId);
    $productObj = $ld->loadData($productObj);


    return $productObj;

  }

}



 ?>
