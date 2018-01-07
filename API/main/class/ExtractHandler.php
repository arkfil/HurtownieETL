<?php
/**
 * Klasa do obs³ugi EXTRACT z procesu ETL
 */
class ExtractHandler{

    /**
     * Metoda do pobierania danych produktu
     * @param $productID Identyfikator produktu
     * @return Obiekt typu DOMDocument dla wskazanego produktu
     */
  public static function extractData($productId){

    $domDataLoader = new DomDataLoader();
    $ceneoDOM = array();
    $ceneoDOM[] = $domDataLoader->loadData('https://www.ceneo.pl/'.$productId.'#tab=reviews');
    $numberOfOpinions = CeneoHtmlParser::getOpinionsCount($ceneoDOM[0]);
    $numberOfPages = ceil($numberOfOpinions/10);
    for($i = 2;$i<=$numberOfPages;++$i){
      $ceneoDOM[] = $domDataLoader->loadData('https://www.ceneo.pl/'.$productId.'/opinie-'.$i);
    }


    return $ceneoDOM;
  }
}


?>
