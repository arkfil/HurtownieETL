<?php
class TransformHandler{

  public static function transformData($roughData, $productId){
    $ceneoParser = new CeneoHtmlParser;

    $prBrand = $ceneoParser->retriveProductBrand($roughData[0]);
    $prType = $ceneoParser->retriveProductType($roughData[0]);
    $prModel = $ceneoParser->retriveProductModel($roughData[0]);
    $opinions = $ceneoParser->retriveOpinions($roughData);

    $product = new Product($productId,$prType,$prBrand,$prModel,'',$opinions);

    return $product;
  }
}


?>
