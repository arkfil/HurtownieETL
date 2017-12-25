<?php
class LoadHandler{

  public static function loadData($productObj){
    $dbCtrl = new DB_ctrl();

    $isPrInDB = $dbCtrl->isProductInDB($productObj->getId());
    if(!$isPrInDB){
      $dbCtrl->saveProductInfo(
                            $productObj->getId(),
                            1,
                            $productObj->getType(),
                            $productObj->getBrand(),
                            $productObj->getModel()
      );
      $dbCtrl->saveRemarks($productObj->getRemarks(),$productObj->getId(),1);
      $dbCtrl->saveOpinions($productObj->getOpinions(),$productObj->getId(),1);
      $dbCtrl->disconnect();
      return $productObj;
    }else{
    //  $latestPrInDb = $dbCtrl -> getProduct($productObj->getId());
      $dbProductObj = $dbCtrl -> getProduct($productObj->getId());
      $isLatestProductInDbTheSameAsExtractedProduct = Product::compare($dbProductObj,$productObj);

      if(!$isLatestProductInDbTheSameAsExtractedProduct){
        $newLp = 1 + $dbCtrl->getLatestProductsLp($dbProductObj->getId());

        $dbCtrl->saveProductInfo(
                              $productObj->getId(),
                              $newLp,
                              $productObj->getType(),
                              $productObj->getBrand(),
                              $productObj->getModel()
        );
        $dbCtrl->saveRemarks($productObj->getRemarks(),$productObj->getId(),$newLp);
        $dbCtrl->saveOpinions($productObj->getOpinions(),$productObj->getId(),$newLp);
        $dbCtrl->disconnect();
        return $productObj;

      }else{
        return $dbProductObj;
      }
    }

  }
}


?>
