<?php

class CeneoHtmlParser{

  public function retriveProductName($ceneoDom){

    $contentNode=$ceneoDom->getElementById("body");
    $longNameElements = self::getElementsByClass($contentNode, 'h1', 'long-name');

    return $longNameElements[0]->nodeValue;
  }

  public function retriveProductBrand($ceneoDom){
    return self::getElementAtributeValueByAnotherAtribute($ceneoDom, 'meta', 'content', 'property', 'og:brand');
  }






  public function retriveProductType($ceneoDom){
    $contentNode=$ceneoDom->getElementById("body");
    $productInfoArr = self::getElementsByClass($contentNode, 'span', 'breadcrumb');
    $index = sizeof($productInfoArr);

    $productCategory = $productInfoArr[$index-1]->nodeValue;
    return $productCategory;
  }

  public function retriveProductTypeAlternative($ceneoDom){
    return self::getElementAtributeValueByAnotherAtribute($ceneoDom, 'meta', 'content', 'property', 'og:type');
  }

  public function retriveProductModel($ceneoDom){
    $contentNode=$ceneoDom->getElementById("body");

    $productInfoArr = self::getElementsByClass($contentNode, 'nav', 'breadcrumbs');
    $productModelElement = self::getElementsByClass($productInfoArr[0], 'strong', 'js_searchInGoogleTooltip')[0];

    return $productModelElement->nodeValue;
  }


  public function retriveOpinions($ceneoDom){
    // TO DO

    $contentNode=$ceneoDom->getElementById("body");
    $opinionPages = self::getElementsByClass($contentNode, 'div', 'pagination');

    $pages = $opinionPages[0]->getElementsByTagName('a');
    echo 'lallalalallalalal:<br>';
    // echo $pages->nodeValue; SHOW MUST GO ON
    // returns Array

    echo $pages[0]->nodeValue;



    echo '<br><br>';
  }

  private function retriveOpinionsStep(){

  }
  private function getOpinionsFromGivenCode(){

  }





// Utiliyy
  private static function getElementAtributeValueByAnotherAtribute($dom, $elementName, $atributeName, $anotherAtributeName, $anotherAtributeValue){
    $nodes=array();

    $childNodeList = $dom->getElementsByTagName($elementName);
    for ($i = 0; $i < $childNodeList->length; $i++) {
        $temp = $childNodeList->item($i);
        if (stripos($temp->getAttribute($anotherAtributeName), $anotherAtributeValue) !== false) {
          return $temp->getAttribute($atributeName);
        }
    }

    return '';

  }



  private static function getElementsByClass(&$parentNode, $tagName, $className) {
      $nodes=array();

      $childNodeList = $parentNode->getElementsByTagName($tagName);
      for ($i = 0; $i < $childNodeList->length; $i++) {
          $temp = $childNodeList->item($i);
          if (stripos($temp->getAttribute('class'), $className) !== false) {
              $nodes[]=$temp;
          }
      }

      return $nodes;
  }

}


?>
