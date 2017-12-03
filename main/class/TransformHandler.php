<?php
class TransformHandler{

  public static function transformData($roughData){
    $ceneoParser = new CeneoHtmlParser;

    $product = new Product('','','','','');

    //$opinions = $ceneoParser.retriveOpinions($ceneoDOM);




    $product->setBrand($ceneoParser->retriveProductBrand($roughData));
    $product->setType($ceneoParser->retriveProductType($roughData));
    $product->setModel($ceneoParser->retriveProductModel($roughData));






    return $product;
  }
}


?>
