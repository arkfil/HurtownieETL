<?php
class TransformHandler{

  public static function transformData($roughData){
    $ceneoParser = new CeneoHtmlParser;

    $feature = array (new Feature('feature 1','1'),new Feature('feature 2','0'));
    $opinion = array (new opinion('1','2','3','4','5','6','7','8',$feature));
    $product = new Product('A','B','C','D',$opinion);

    //$opinions = $ceneoParser.retriveOpinions($ceneoDOM);




    $product->setBrand($ceneoParser->retriveProductBrand($roughData));
    $product->setType($ceneoParser->retriveProductType($roughData));
    $product->setModel($ceneoParser->retriveProductModel($roughData));

//

    // $product->setOpinions($ceneoParser->retriveOpinions($roughData));


    $ceneoParser->retriveOpinions($roughData);






    return $product;
  }
}


?>
