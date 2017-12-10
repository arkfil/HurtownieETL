<?php

class Opinion
{
  private $id;
  private $parentOpinion;
  private $date;
  private $summary;
  private $stars;
  private $author;
  private $isPositive;
  private $upVotesCount;
  private $downVotesCount;

  private $features;

  function __construct($pId, $pParentOpinion, $pDate, $pSummary, $pStars, $pAuthor, $pIsPositive, $pUpVotesCount, $pDownVotesCount, $pFeatures)
  {
    $this->id = $pId;
    $this->parentOpinion = $pParentOpinion;
    $this->date = $pDate;
    $this->summary = $pSummary;
    $this->stars = $pStars;
    $this->author = $pAuthor;
    $this->isPositive = $pIsPositive;
    $this->upVotesCount = $pUpVotesCount;
    $this->downVotesCount = $pDownVotesCount;
    $this->features = $pFeatures;
  }

  public function setId($pId){                          $this->id = $pId; }
  public function setParentOpinion($pParentOpinion){    $this->parentOpinion = $pParentOpinion;  }
  public function setDate($pDate){                      $this->date = $pDate;  }
  public function setSummary($pSummary){                $this->summary = $pSummary;  }
  public function setStars($pStars){                    $this->stars = $pStars;  }
  public function setAuthor($pAuthor){                  $this->author = $pAuthor;  }
  public function setIsPositive($pIsPositive){          $this->isPositive = $pIsPositive;  }
  public function setUpVotesCount($pUpVotesCount){      $this->upVotesCount = $pUpVotesCount;  }
  public function setDownVotesCount($pDownVotesCount){  $this->downVotesCount = $pDownVotesCount;  }
  public function setFeatures($pFeatures){              $this->features = $pFeatures;  }


  public function getId(){                  return $this->id; }
  public function getParentOpinion(){       return $this->parentOpinion;  }
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
           '"up-votes":"'.$this->upVotesCount.'",'.
           '"down-votes":"'.$this->downVotesCount.'",'.
           '"features":[';

     if(is_array($this->features)){
       $numberOfFeatures = sizeof($this->features);
       $numberOfFeatures-=1;
       for($f=0;$f<=$numberOfFeatures;++$f){
         if($f!=$numberOfFeatures)
            $opStr = $opStr.$this->features[$f].',';
          else
            $opStr = $opStr.$this->features[$f];
       }
     }

     $opStr = $opStr."]}";
     return $opStr;
  }

}


 ?>
