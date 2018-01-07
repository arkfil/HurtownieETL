<?php
/**
 * Klasa do obs�ugi po��cze� z baz� danych aplikacji.
 */
class DB{
  private $serverName;
  private $userNname;
  private $password;
  private $dbName;
 
  
  /**
   * Konstruktor klasy.
   * @param $pServerName Nazwa serwera.
   * @param $pUserNname Nazwa u�ytkownika.
   * @param $pPassword Has�o.
   * @param $pDbName Nazwa bazy danych.
   * @return Obiekt typu Product.
   */
  function __construct($pServerName,$pUserNname,$pPassword,$pDbName){
    $this->serverName=$pServerName;
    $this->userNname=$pUserNname;
    $this->password=$pPassword;
    $this->dbName = $pDbName;
    ini_set('max_execution_time', 0);
  }

  /**
   * Metoda do otwarcia po��czenia z serweram bazy danych.
   * @return obiekt PDO z aktywnym po��czeniem lub '%' je�eli nie uda�o si� nawi�za� po��czenia
   */ 
  public function connect(){
    try {
      $connection = new PDO("mysql:host=".$this->serverName.";dbname=".$this->dbName, $this->userNname, $this->password);
      // set the PDO error mode to exception
      $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $connection;
    }catch(PDOException $e){
      // return $e->getMessage();
      return "%";
    }
  }
  
  /**
   * Metoda do wywo�ania polecenia INSERT w bazie danych
   * @param $connection obiekt PDO z aktywnym po��czeniem
   * @param $statement Polecenie SQL typu INSERT
   * @return identyfikator wprowadzonego rekordu lub '%' je�eli wyst�pi� b��d
   */
  public function insertStatement($connection, $statement){
    try {
      $connection->exec($statement);
      return $connection->lastInsertId();
    }catch(PDOException $e){
      return "%";
    }
  }
  
  
  /**
   * Metoda do wywo�ania polecenia SELECT na wielu rekordach
   * @param $connection obiekt PDO z aktywnym po��czeniem
   * @param $statement Polecenie SQL typu SELECT
   * @return tablica z rekordami zwr�conymi przez zapytanie lub '%' je�eli wyst�pi� b��d
   */
  public function selectWhole($connection, $statement){
  try {
      $stmt = $connection->prepare($statement);
      $stmt->execute();
      // set the resulting array to associative
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      // echo json_encode($result);
      return $result;
  }catch(PDOException $e) {
    return "%";
  }
}

/**
 * Metoda do wywo�ania polecenia SELECT pobieraj�ca jeden rekord
 * @param $connection obiekt PDO z aktywnym po��czeniem
 * @param $statement Polecenie SQL typu SELECT
 * @return tablica z rekordem zwr�conym przez zapytanie lub '%' je�eli wyst�pi� b��d
 */
public function selectOne($connection, $statement){
  try {
      $stmt = $connection->prepare($statement);
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_NUM);
      $result = $stmt->fetch();
      return $result;
  }catch(PDOException $e) {
    return "%";
  }
}

/**
 * Metoda do sprawdzenia liczby wnik�w zapytnia SQL
 * @param $connection obiekt PDO z aktywnym po��czeniem
 * @param $statement Polecenie SQL
 * @return liczba wynik�w lub '%' je�eli wyst�pi� b��d
 */
public function checkOccurenceCount($connection, $statement){
  try {
      $stmt = $connection->prepare($statement);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_NUM);
      return reset($count);
  }catch(PDOException $e) {
    return "%";
  }
}
}
?>
