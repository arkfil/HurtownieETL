<?php
class ExtractHandler{

  public static function extractData($productId){


    $domDataLoader = new DomDataLoader();


    $ceneoDOM = $domDataLoader->loadData('https://www.ceneo.pl/'.$productId.'#tab=reviews');




    // echo $ceneoDOM->getElementById('body')->nodeValue;





    // $dataExtractor = new DomDataLoader();
    //
    //
    // //$data = $dataExtractor -> loadData('https://www.ceneo.pl/'.$productId.'#tab=reviews');
    // //$data = $dataExtractor -> loadData('https://www.ceneo.pl/45095617');
    // $data = $dataExtractor->loadData('https://www.ceneo.pl/52404834#tab=reviews');
    //
    // echo 'lol'.$data->nodeValue;

    return $ceneoDOM;
  }
}


?>
