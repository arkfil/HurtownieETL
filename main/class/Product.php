<?php

class Product{

  private $type;
  private $brand;
  private $model;

  private $remarks;
  private $opinions;

  public function setType($pType){         $this->type = $pType; }
  public function setBrand($pBrand){       $this->brand = $pBrand; }
  public function setModel($pModel){       $this->model = $pModel; }
  public function setRemarks($pRemarks){   $this->remarks = $pRemarks; }
  public function setOpinions($pOpinions){ $this->opinions = $pOpinions; }

  public function getType(){      return $this->type; }
  public function getBrand(){     return $this->brand; }
  public function getModel(){     return $this->model; }
  public function getRemarks(){   return $this->remarks; }
  public function getOpinions(){  return $this->opinions; }


  function __construct($pType, $pBrand, $pModel, $pRemarks, $pOpinions) {
    $type = $pType;
    $brand = $pBrand;
    $model = $pModel;
    $remarks = $pRemarks;
    $opinions = $pOpinions;
  }


  public function __toString()
  {
      return 'Type: '.$this->type.'<br>'.
       'Brand: '.$this->brand.'<br>'.
       'Model: '.$this->model.'<br>';
  }

}


 ?>
