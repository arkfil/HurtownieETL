<?php
class LoadHandler{

  public static function loadData($poductObj){
    $dbCtrl = new DB_ctrl();

    $isPrInDB = $dbCtrl->isProductInDB($poductObj->getId());
    if(!$isPrInDB){
      $dbCtrl->saveProductInfo(
                            $poductObj->getId(),
                            $poductObj->getType(),
                            $poductObj->getBrand(),
                            $poductObj->getModel()
      );
      $dbCtrl->saveRemarks($poductObj->getRemarks(),$poductObj->getId());
      $dbCtrl->saveOpinions($poductObj->getOpinions(),$poductObj->getId());

      $dbCtrl->disconnect();
    }else{
      //CHECK WHETHER PRODUCT HAS BEEN UPDATED
    }

    return true;
  }
}


?>
