<?php

class Product{
  private $id;
  private $type;
  private $brand;
  private $model;

  private $remarks;
  private $opinions;

  public function setId($pId){             $this->id = $pId; }
  public function setType($pType){         $this->type = $pType; }
  public function setBrand($pBrand){       $this->brand = $pBrand; }
  public function setModel($pModel){       $this->model = $pModel; }
  public function setRemarks($pRemarks){   $this->remarks = $pRemarks; }
  public function setOpinions($pOpinions){ $this->opinions = $pOpinions; }

  public function getId(){        return $this->id; }
  public function getType(){      return $this->type; }
  public function getBrand(){     return $this->brand; }
  public function getModel(){     return $this->model; }
  public function getRemarks(){   return $this->remarks; }
  public function getOpinions(){  return $this->opinions; }


  function __construct($pId, $pType, $pBrand, $pModel, $pRemarks, $pOpinions) {
    $this->id = $pId;
    $this->type = $pType;
    $this->brand = $pBrand;
    $this->model = $pModel;
    $this->remarks = $pRemarks;
    $this->opinions = $pOpinions;
  }


  public function __toString()
  {

    $productStr = '{'.
              '"type":"'.$this->type.'",'.
              '"brand":"'.$this->brand.'",'.
              '"model":"'.$this->model.'",'.
               '"remarks":[';
     if(is_array($this->remarks)){
       $rmarksCount = sizeof($this->remarks);
       $rmarksCount-=1;
       for($j=0;$j<=$rmarksCount;++$j){
         if($j!=$rmarksCount && $rmarksCount!=0)
            $productStr = $productStr.$this->remarks[$j].',';
          else
            $productStr = $productStr.$this->remarks[$j];
       }
     }


    $productStr=$productStr.'],"opinions":[';

     if(is_array($this->opinions)){
       $opinionsCount = sizeof($this->opinions);
       $opinionsCount-=1;
       for($j=0;$j<=$opinionsCount;++$j){
         if($j!=$opinionsCount && $opinionsCount!=0)
            $productStr = $productStr.$this->opinions[$j].',';
          else
            $productStr = $productStr.$this->opinions[$j];
       }
     }

     $productStr = $productStr."]}";





      return $productStr;
  }

}


 ?>
