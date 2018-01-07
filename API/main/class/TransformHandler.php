<?php
/**
 * Klasa do obs³ugi TRANSFORM z procesu ETL
 */
class TransformHandler{
    /**
     * Metoda do pobierania Produktu na podstawie jego ID.
     * @param $roughData obiekt typu DOMDocument
     * @param $productId Identyfikator produktu
     * @return Obiekt typu Product
     */
  public static function transformData($roughData, $productId){
    $ceneoParser = new CeneoHtmlParser;

    $prBrand = $ceneoParser->retriveProductBrand($roughData[0]);
    $prType = $ceneoParser->retriveProductType($roughData[0]);
    $prModel = $ceneoParser->retriveProductModel($roughData[0]);
    $opinions = $ceneoParser->retriveOpinions($roughData);
    $remarks = $ceneoParser->getRemarks($roughData[0]);

    $product = new Product($productId,$prType,$prBrand,$prModel,$remarks,$opinions);

    return $product;
  }
}


?>
