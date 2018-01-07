<?php
/**
 * Klasa do obs³ugi LOAD z procesu ETL
 */
class LoadHandler{

    /**
     * Metoda do kompleksowego ³adowania produktu do bazy danych
     * @param $productObj Obiekt typu Product
     * @return obiekt typu Product, je¿eli nie by³o w bazie lub obiekt typu Product z nowym LP je¿eli ju¿ istnia³ pod wskazanym ID, lub obiekt typu Product, je¿eli taki sam ju¿ istnieje w bazie 
     */
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
