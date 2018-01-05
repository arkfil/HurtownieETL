<?php

class Opinion
{
  private $id;
  // private $parentOpinion;
  private $date;
  private $summary;
  private $stars;
  private $author;
  private $isPositive;
  private $upVotesCount;
  private $downVotesCount;

  private $features;

  function __construct($pId, $pDate, $pSummary, $pStars, $pAuthor, $pIsPositive, $pUpVotesCount, $pDownVotesCount, $pFeatures)
  {
    $this->id = $pId;
    // $this->parentOpinion = $pParentOpinion;
    $this->date = $pDate;
    $this->summary = $pSummary;
    $this->stars = $pStars;
    $this->author = $pAuthor;
    $this->isPositive = $pIsPositive;
    $this->upVotesCount = $pUpVotesCount;
    $this->downVotesCount = $pDownVotesCount;
    $this->features = $pFeatures;
  }

  public static function compare($opOne,$opTwo){

    if(sizeof($opOne->getFeatures())!=sizeof($opTwo->getFeatures())) return false;

    $opFeaturesArrOne = $opOne->getFeatures();
    $opFeaturesArrTwo = $opOne->getFeatures();
    sort($opFeaturesArrOne);
    sort($opFeaturesArrTwo);


    for($z=0;$z<sizeof($opFeaturesArrOne);++$z){
      if(!Feature::compare($opFeaturesArrOne[$z],$opFeaturesArrTwo[$z])) return false;
    }

    if($opOne->getId()!=$opTwo->getId()) return false;
    if($opOne->getDate()!=$opTwo->getDate()) return false;
    if($opOne->getSummary()!=$opTwo->getSummary()) return false;
    if($opOne->getStars()!=$opTwo->getStars()) return false;
    if($opOne->getAuthor()!=$opTwo->getAuthor()) return false;
    if($opOne->getIsPositive()!=$opTwo->getIsPositive()) return false;
    if($opOne->getUpVotesCount()!=$opTwo->getUpVotesCount()) return false;
    if($opOne->getDownVotesCount()!=$opTwo->getDownVotesCount()) return false;

    return true;
  }

  public function setId($pId){                          $this->id = $pId; }
  // public function setParentOpinion($pParentOpinion){    $this->parentOpinion = $pParentOpinion;  }
  public function setDate($pDate){                      $this->date = $pDate;  }
  public function setSummary($pSummary){                $this->summary = $pSummary;  }
  public function setStars($pStars){                    $this->stars = $pStars;  }
  public function setAuthor($pAuthor){                  $this->author = $pAuthor;  }
  public function setIsPositive($pIsPositive){          $this->isPositive = $pIsPositive;  }
  public function setUpVotesCount($pUpVotesCount){      $this->upVotesCount = $pUpVotesCount;  }
  public function setDownVotesCount($pDownVotesCount){  $this->downVotesCount = $pDownVotesCount;  }
  public function setFeatures($pFeatures){              $this->features = $pFeatures;  }


  public function getId(){                  return $this->id; }
  // public function getParentOpinion(){       return $this->parentOpinion;  }
  public function getDate(){                return $this->date;  }
  public function getSummary(){             return $this->summary;  }
  public function getStars(){               return $this->stars;  }
  public function getAuthor(){              return $this->author;  }
  public function getIsPositive(){          return $this->isPositive;  }
  public function getUpVotesCount(){        return $this->upVotesCount;  }
  public function getDownVotesCount(){      return $this->downVotesCount;  }
  public function getFeatures(){            return $this->features;  }



  public function __toString(){
    $opStr = '{'.
           '"id":"'.$this->id.'",'.
           '"date":"'.$this->date.'",'.
           '"summary":"'.$this->summary.'",'.
           '"stars":"'.$this->stars.'",'.
           '"author":"'.$this->author.'",'.
           '"positive":"'.$this->isPositive.'",'.
           '"up_votes":"'.$this->upVotesCount.'",'.
           '"down_votes":"'.$this->downVotesCount.'",'.
           '"advantages": [ ';

     if(is_array($this->features)){
       $numberOfFeatures = sizeof($this->features);
       for($f=0;$f<$numberOfFeatures;++$f){
         if($this->features[$f]->getIsAdv()==1)
              $opStr = $opStr.$this->features[$f].',';
       }
       $opStr = substr($opStr,0,(strlen($opStr)-1));
     }

     $opStr = $opStr."],";

     $opStr = $opStr.'"disadvantages":[ ';

        if(is_array($this->features)){
          $numberOfFeatures = sizeof($this->features);
          for($g=0;$g<$numberOfFeatures;++$g){
           if($this->features[$g]->getIsAdv()==0)
                $opStr = $opStr.$this->features[$g].',';
          }
          $opStr = substr($opStr,0,(strlen($opStr)-1));
        }


     $opStr = $opStr."]}";

     return $opStr;
  }

}


 ?>
