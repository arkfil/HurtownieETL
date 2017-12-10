<?php
class Feature{
  private $name;
  private $isAdv;

  function __construct($pName, $pIsAdv){
    $this->name = $pName;
    $this->isAdv = $pIsAdv;
  }
  public function setIsAdv($pIsAdv){
    $this->isAdv = $pIsAdv;
  }
  public function setName($pName){
      $this->name = $pName;
  }

  public function getIsAdv(){
    return $this->isAdv;
  }
  public function getName(){
      return $this->name;
  }


public function __toString(){
  return '{"name":"'.$this->name.'","advantage":'.$this->isAdv.'}';
}

}

 ?>
