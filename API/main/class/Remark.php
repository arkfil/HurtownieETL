<?php
class Remark{

  private $name;

  function __construct($pName)
  {
    $this->name = $pName;
  }

  public function setName($pName){  $this->name = $pName; }
  public function getName(){        return $this->name; }


  public function __toString(){
    return '"'.$this->name.'"';
  }


}


 ?>
