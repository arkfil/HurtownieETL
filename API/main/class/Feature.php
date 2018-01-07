<?php

/**
 * Klasa przechowuj¹ca wady i zalety w opinii produktu
 */
class Feature{
  private $name;
  private $isAdv;

  /**
   * Konstruktor klasy
   * @param $pName nazwa
   * @param $pIsAdv flaga czy Feature jest wad¹ (0) czy zalet¹ (1)
   */
  function __construct($pName, $pIsAdv){
    $this->name = $pName;
    $this->isAdv = $pIsAdv;
  }

  /**
   * Metoda do porównywania dwóch obiektów typu Feature
   * @param $feaOne Obiekt typu Feature
   * @param $feaTwo Obiekt typu Feature
   * @return True je¿eli s¹ takie same, False je¿eli s¹ ró¿ne
   */
  public static function compare($feaOne,$feaTwo){
    if($feaOne->getName()!=$feaTwo->getName()) return false;
    if($feaOne->getIsAdv()!=$feaTwo->getIsAdv()) return false;

    return true;
  }

  /**
   * Metoda do ustawienia czy Feature jest wad¹ czy zalet¹
   * @param $pIsAdv 1 je¿eli zaleta, 0 je¿eli wada
   */
  public function setIsAdv($pIsAdv){
    $this->isAdv = $pIsAdv;
  }
  
  /**
   * Metoda do ustawienia nazwy
   * @param $pName nazwa
   */
  public function setName($pName){
      $this->name = $pName;
  }

  /**
   * Metoda do sprawdzenia czy obiekt jest wad¹ czy zalet¹
   * @return 1 je¿eli zaleta, 0 je¿eli wada
   */
  public function getIsAdv(){
    return trim($this->isAdv);
  }
  
  /**
   * Metoda do pobrania nazwy
   * @return nazwa
   */
  public function getName(){
      return $this->name;
  }

  /**
   * Metoda do rzutowania obiektu na typ String
   */
public function __toString(){
  return '"'.$this->name.'"';
}

}

 ?>
