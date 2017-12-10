<?php

class CeneoHtmlParser{

  public function retriveProductName($ceneoDom){

    $contentNode=$ceneoDom->getElementById("body");
    $longNameElements = self::getElementsByClass($contentNode, 'h1', 'long-name');
    $prName = $longNameElements[0]->nodeValue;

    return urlencode(trim($prName));
  }

  public function retriveProductBrand($ceneoDom){
    $prBrand = self::getElementAtributeValueByAnotherAtribute($ceneoDom, 'meta', 'content', 'property', 'og:brand');
    return urlencode(trim($prBrand));
  }

  public function retriveProductType($ceneoDom){
    $contentNode=$ceneoDom->getElementById("body");
    $productInfoArr = self::getElementsByClass($contentNode, 'span', 'breadcrumb');
    $index = sizeof($productInfoArr);
    $productCategory = $productInfoArr[$index-1]->nodeValue;

    return urlencode(trim($productCategory));
  }

  public function retriveProductTypeAlternative($ceneoDom){
    return self::getElementAtributeValueByAnotherAtribute($ceneoDom, 'meta', 'content', 'property', 'og:type');
  }

  public function retriveProductModel($ceneoDom){
    $contentNode=$ceneoDom->getElementById("body");

    $productInfoArr = self::getElementsByClass($contentNode, 'nav', 'breadcrumbs');
    $productModelElement = self::getElementsByClass($productInfoArr[0], 'strong', 'js_searchInGoogleTooltip')[0];
    $prModel = $productModelElement->nodeValue;

    return urlencode(trim($prModel));
  }


  public function retriveOpinions($ceneoDomArr){
    // TO DO
    $opinions = array();
    for($i=0;$i<sizeof($ceneoDomArr);++$i){
      $this->retrivePagessOpinions($ceneoDomArr[$i],$opinions);
    }

    return $opinions;
  }

  private function retrivePagessOpinions($singlePage, &$opninionsArray){

    //$opinion =
    $contentNode=$singlePage->getElementById("body");
    $opinionsList = self::getElementsByClass($contentNode, 'ol', 'product-reviews')[0];
    $opinionsListElements = self::getElementsByClass($opinionsList, 'li', 'review-box');

    for($j = 0;$j<sizeof($opinionsListElements);++$j){
      $parentOpinion = "";
      $opId = urlencode(trim(   $this -> retriveOpinionId($opinionsListElements[$j])));
      $date = urlencode(trim(   $this -> retriveOpinionDate($opinionsListElements[$j])));
      $summary = urlencode(trim(    $this -> retriveOpinionSummary($opinionsListElements[$j])));
      $stars = urlencode(trim(    $this -> retriveOpinionStars($opinionsListElements[$j])));
      $author = urlencode(trim(   $this -> retriveOpinionAuthor($opinionsListElements[$j])));
      $isPositive = urlencode(trim(   $this -> retriveOpinionTypeOfEfect($opinionsListElements[$j])));
      $upVotesCount = urlencode(trim(   $this -> retriveOpinionUpVotesCount($opinionsListElements[$j])));
      $downVotesCount = urlencode(trim(   $this -> retriveOpinionDownVotesCount($opinionsListElements[$j])));
      $features = $this -> retriveOpinionFeatures($opinionsListElements[$j]);


      $opninionsArray[] = new Opinion($opId, $parentOpinion, $date, $summary, $stars, $author, $isPositive, $upVotesCount, $downVotesCount, $features);
    }

  }
  private function retriveOpinionId($singleOpinion){
    return self::getElementsByClass($singleOpinion, "button", "js_vote-yes")[0] -> getAttribute("data-review-id");
  }
  private function retriveOpinionDate($singleOpinion){
    return $singleOpinion -> getElementsByTagName("time")[0] -> getAttribute("datetime");
  }
  private function retriveOpinionSummary($singleOpinion){
    return self::getElementsByClass($singleOpinion, "p", "product-review-body")[0] -> nodeValue;
  }
  private function retriveOpinionStars($singleOpinion){
    $rate = self::getElementsByClass($singleOpinion, "span", "review-score-count")[0] -> nodeValue;
    return substr($rate,0,strpos($rate,"/"));
  }
  private function retriveOpinionAuthor($singleOpinion){
    $name = self::getElementsByClass($singleOpinion, "div", "reviewer-name-line")[0] -> nodeValue;
    return trim($name);
  }
  private function retriveOpinionTypeOfEfect($singleOpinion){
    return sizeof(self::getElementsByClass($singleOpinion, "em", "product-recommended"));
  }
  private function retriveOpinionUpVotesCount($singleOpinion){
    return self::getElementsByClass($singleOpinion, "button", "js_vote-yes")[0] -> getAttribute("data-total-vote");
  }
  private function retriveOpinionDownVotesCount($singleOpinion){
    return self::getElementsByClass($singleOpinion, "button", "js_vote-no")[0] -> getAttribute("data-total-vote");
  }
  private function retriveOpinionFeatures($singleOpinion){
    $featuresArr = array();

    $listEl = self::getElementsByClass($singleOpinion, "div", "pros-cell")[0];
    $prosElementsArr = $listEl -> getElementsByTagName('li');

    foreach($prosElementsArr as $pro) {
      $featuresArr[] = new Feature( urlencode(trim( $pro->nodeValue)) ,1);
    }

    $listEl = self::getElementsByClass($singleOpinion, "div", "cons-cell")[0];
    $consElementsArr = $listEl -> getElementsByTagName('li');

    foreach($consElementsArr as $con) {
      $featuresArr[] = new Feature(  urlencode(trim( $con->nodeValue)) ,0);
    }

    return $featuresArr;
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


  public static function getOpinionsCount($roughPage){
        $contentNode=$roughPage->getElementById("body");
        $reviewCountString = self::getElementsByClass($contentNode, 'li', 'reviews')[0];


        $opinionsCount = filter_var($reviewCountString->nodeValue, FILTER_SANITIZE_NUMBER_INT);
        if(is_numeric($opinionsCount))
          return $opinionsCount;
        else
          return 0;
  }

}


?>
