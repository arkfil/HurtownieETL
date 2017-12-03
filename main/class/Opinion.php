<?php

class Opinion
{

  private $parentOpinion;
  private $date;
  private $summary;
  private $stars;
  private $author;
  private $isPositive;
  private $upVotesCount;
  private $downVotesCount;

  private $features;

  function __construct($pParentOpinion, $pDate, $pSummary, $pStars, $pAuthor, $pIsPositive, $pUpVotesCount, $pDownVotesCount, $pFeatures)
  {
    $parentOpinion = $pParentOpinion;
    $date = $pDate;
    $summary = $pSummary;
    $stars = $pStars;
    $author = $pAuthor;
    $isPositive = $pIsPositive;
    $upVotesCount = $pUpVotesCount;
    $downVotesCount = $pDownVotesCount;
    $features = $pFeatures;
  }

  public function setParentOpinion($pParentOpinion){    $this->parentOpinion = $pParentOpinion;  }
  public function setDate($pDate){                      $this->date = $pDate;  }
  public function setSummary($pSummary){                $this->summary = $pSummary;  }
  public function setStars($pStars){                    $this->stars = $pStars;  }
  public function setAuthor($pAuthor){                  $this->author = $pAuthor;  }
  public function setIsPositive($pIsPositive){          $this->isPositive = $pIsPositive;  }
  public function setUpVotesCount($pUpVotesCount){      $this->upVotesCount = $pUpVotesCount;  }
  public function setDownVotesCount($pDownVotesCount){  $this->downVotesCount = $pDownVotesCount;  }
  public function setFeatures($pFeatures){              $this->features = $pFeatures;  }


  public function getParentOpinion(){       return $this->parentOpinion;  }
  public function getDate(){                return $this->date;  }
  public function getSummary(){             return $this->summary;  }
  public function getStars(){               return $this->stars;  }
  public function getAuthor(){              return $this->author;  }
  public function getIsPositive(){          return $this->isPositive;  }
  public function getUpVotesCount(){        return $this->upVotesCount;  }
  public function getDownVotesCount(){      return $this->downVotesCount;  }
  public function getFeatures(){            return $this->features;  }


}


 ?>
