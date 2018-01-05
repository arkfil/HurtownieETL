<?php

class CeneoHtmlParser{
  private static $remarksPaternArr = array(
  "Gwiezdna Szarość","Biało-Srebrny","Brązowy","Czarno-biały","Czarno-Grafitowy","Czarno-Srebrny","Niebiesko-Czarny", "Niebiesko-czerwony","Czerwony", "Kremowy","Niebieski","Różowy","Wielokolorowy",
  "Czarny", "Biały", "Brązowy", "Brunatny", "Czekoladowy", "Czerwony", "Fioletowy", "Grafitowy", "Granatowy",
  "Miedziany", "miętowy", "Miodowy", "Niebieski", "Pomarańczowy", "Popielaty", "Różowy", "Srebrny", "Stare złoto", "Złoty", "Szafirowy", "Srebrny",
  "Metalowy", "Szmaragdowy", "Wiśniowy", "Zielony", "Zółty", "Szarość", "Różowe złoto",
  "Biała", "Białe", "Czarna","Złota","Czarne", "Grafit",
  "Matowy", "Lśniący", "Błyszczący", "Arktyczne srebro",
  "OC",
  "Edycja Specjalna",
  "Bez reklam","Z reklamami",
  "Rose Gold","Midnight Black","Arctic Silver", "Rose", "White", "Black", "Red", "Yellow", "Blue", "Pink", "Orange", "Magenta", "Cyjan", "Purple", "Star Grey","Grey", "Gold", "Golden", "Silver",
  "Special Edition",
  "2G","3G","4G LTE","4G(LTE)", "4G (LTE)","LTE", "WiFI",
  "Tytanowy","Aluminowy","Skórzany","Drewniany","Stalowy", "Carbonowy", "Platynowy",
  "Titanium","Titan","Alloy","Leather","Wooden","Steel", "Carbon",
  "Złoto", "Srebro", "Drewno", "Aluminium", "Stal nierdzewna",
  "Dual Sim",
  "IPS","Retina","Super AMOLED","TFT","TN",
  "GPS","Bluetooth", "USB-C","USB 2.0", "USB 2", "USB 3.1", "USB 3.0", "USB 3" , "USB",
  "Home Box","Home","Proffesional","Education", "Enterprise","Linux",
  "Eng","Pl",
  "Polska", "Angielska",
  "Full HD 1080p","UHF","Ultra HD","4k","2k","8k", "720p","1080p", "1440p",
  "Class 2", "Class 4", "Class 6", "Class 10", "UHS-I",
  "(Szare Kontrolery)",
  "320×240","(4:3)","HVGA","480×320","(3:2)","VGA","640×480","WVGA","800×480","(5:3)","SVGA","800×600","XGA","1024×768","HDTV","720p","1280×720","(16:9)","HDTV","1366×768","WXGA",
  "1280×800","(16:10)","WXGA+","1440×900","SXGA","1280×1024","(5:4)","WSXGA","1600×1024","SXGA+","1400×1050","WSVGA","1024×600","WSXGA+","1680×1050","UXGA","1600×1200","HD+","1600×900","HDTV"
  ,"1920×1080","WUXGA","1920×1200","QWXGA","2048×1152","QXGA","2048×1536","Cinema TV","2560×1080","(21:9)","WQHD","2560×1440","WQXGA","2560×1600","QSXGA","2560×2048","2048×1152","2048×1024",
  "3K","3072×1728","3072×1536",
  "4096×2304","4096×2048","8192×4608","8192×4096","16384x9216","16K","16384x8192","(2:1)","720×576","360×576","640×482","VHS,320×482","648×486","720×486","720×540","720×486","720×576",
  "768×576","HDTV","1280×720","HDTV","1080i","1080p","1920×1080","3840×2160","UHDTV","7680×4320","2048×1536","Blu-ray","1280×720","1920×1080","720×576","720×480","Laserdisc","560×360","1920x1200",
  "Android","Windows Phone", "Windows Mobile","Windows 10","Windosw 8.1", "Windows 8.1","Windows 8", "Windows 7","Windows", "iOS", "Chrome OS"
  );



  public function retriveProductName($ceneoDom){

    $contentNode=$ceneoDom->getElementById("body");
    $longNameElements = self::getElementsByClass($contentNode, 'h1', 'long-name');
    $prName = $longNameElements[0]->nodeValue;

    return rawurlencode(trim($prName));
  }
  //
  // retriveRemarksList($ceneoDom){
  //
  // }

  public function retriveProductBrand($ceneoDom){
    $prBrand = self::getElementAtributeValueByAnotherAtribute($ceneoDom, 'meta', 'content', 'property', 'og:brand');
    return rawurlencode(trim($prBrand));
  }

  public function retriveProductType($ceneoDom){
    $contentNode=$ceneoDom->getElementById("body");
    $productInfoArr = self::getElementsByClass($contentNode, 'span', 'breadcrumb');
    $index = sizeof($productInfoArr);
    $productCategory = $productInfoArr[$index-1]->nodeValue;

    return rawurlencode(trim($productCategory));
  }

  public function retriveProductTypeAlternative($ceneoDom){
    return self::getElementAtributeValueByAnotherAtribute($ceneoDom, 'meta', 'content', 'property', 'og:type');
  }

  public function retriveProductModel($ceneoDom){
    $contentNode=$ceneoDom->getElementById("body");

    $productInfoArr = self::getElementsByClass($contentNode, 'nav', 'breadcrumbs');
    $productModelElement = self::getElementsByClass($productInfoArr[0], 'strong', 'js_searchInGoogleTooltip')[0];
    $prModel = $productModelElement->nodeValue;

    // return rawurlencode(trim($this->cutOutRemarks($prModel)));
    return rawurlencode(trim($prModel));
  }

  public function getRemarks($ceneoDom){


    return self::cutOutRemarks($ceneoDom);
  }

  public function retriveOpinions($ceneoDomArr){
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
      $opId = rawurlencode(trim(   $this -> retriveOpinionId($opinionsListElements[$j])));
      $date = rawurlencode(trim(   $this -> retriveOpinionDate($opinionsListElements[$j])));
      $summary = rawurlencode(trim(    $this -> retriveOpinionSummary($opinionsListElements[$j])));
      $stars = rawurlencode(trim(    $this -> retriveOpinionStars($opinionsListElements[$j])));
      $author = rawurlencode(trim(   $this -> retriveOpinionAuthor($opinionsListElements[$j])));
      $isPositive = rawurlencode(trim(   $this -> retriveOpinionTypeOfEfect($opinionsListElements[$j])));
      $upVotesCount = rawurlencode(trim(   $this -> retriveOpinionUpVotesCount($opinionsListElements[$j])));
      $downVotesCount = rawurlencode(trim(   $this -> retriveOpinionDownVotesCount($opinionsListElements[$j])));
      $features = $this -> retriveOpinionFeatures($opinionsListElements[$j]);


      $opninionsArray[] = new Opinion($opId, $date, $summary, $stars, $author, $isPositive, $upVotesCount, $downVotesCount, $features);
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
      if(!ctype_space($pro->nodeValue)){
        $featuresArr[] = new Feature( rawurlencode(trim( $pro->nodeValue)) ,1);
      }
    }

    $listEl = self::getElementsByClass($singleOpinion, "div", "cons-cell")[0];
    $consElementsArr = $listEl -> getElementsByTagName('li');

    foreach($consElementsArr as $con) {
      if(!ctype_space($con->nodeValue)){
        $featuresArr[] = new Feature(  rawurlencode(trim( $con->nodeValue)) ,0);
      }
    }

    return $featuresArr;
  }

  private static function cutOutRemarks($ceneoDom){
      $contentNode=$ceneoDom->getElementById("body");
      $productInfoArr = self::getElementsByClass($contentNode, 'nav', 'breadcrumbs');
      $productModelElement = self::getElementsByClass($productInfoArr[0], 'strong', 'js_searchInGoogleTooltip')[0];
      $stringTitle = $productModelElement->nodeValue;


      $productDataDOM = self::getElementsByClass($contentNode, 'article', 'product-top')[0];
      $productTags = self::getElementsByClass($productDataDOM, 'div', 'ProductSublineTags')[0];
      $stringTitle = $stringTitle." ".$productTags->nodeValue;

      $remarksArr = array();
      // $remarksPaternArr
      foreach(self::$remarksPaternArr as $pattern) {
        if(strpos($stringTitle, $pattern)!==false)
          if(!ctype_space($pattern))
            $remarksArr[] = new Remark( rawurlencode(trim($pattern)));
      }

      if (preg_match(
      '/[0-9]{0,}[.,]{0,1}[0-9]+((GB)|(gb)|(Gb)|(MB)|(Mb)|(mb)|(KB)|(Kb)|(kb)|(TB)(Tb)|(tb)|(mhz)|(Mhz)|(MHZ)|(mpx)|(Mpx)|(MPX)|(Mah)|(mah)|(MAH)|(wh)|(Wh)|(WH)|(cali)|(Cali)|(cale)|(Cale)|(cala)|(Cala)|(")){1}/',
      $stringTitle,$matches)) {
        if(trim($matches[0])!='()' || strlen(trim($matches[0]))>0){
          if(!ctype_space(trim($matches[0])))
            $remarksArr[] = new Remark( rawurlencode(trim($matches[0])));
          }
      }
      if (preg_match(
      '/[0-9]{0,}[.,]{0,1}[0-9]+\s{1}((GB)|(gb)|(Gb)|(MB)|(Mb)|(mb)|(KB)|(Kb)|(kb)|(TB)(Tb)|(tb)|(mhz)|(Mhz)|(MHZ)|(mpx)|(Mpx)|(MPX)|(Mah)|(mah)|(MAH)|(wh)|(Wh)|(WH)|(cali)|(Cali)|(cale)|(Cale)|(cala)|(Cala)|(")){1}/',
      $stringTitle,$matches)) {
        if(trim($matches[0])!='()' || strlen(trim($matches[0]))>0){
          if(!ctype_space(trim($matches[0])))
            $remarksArr[] = new Remark( rawurlencode(trim($matches[0])));

        }
      }






    return $remarksArr;
  }


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
