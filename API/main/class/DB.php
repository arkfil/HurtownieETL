<?php
/**
 * Klasa do obs³ugi po³¹czeñ z baz¹ danych aplikacji.
 */
class DB{
  private $serverName;
  private $userNname;
  private $password;
  private $dbName;
 
  
  /**
   * Konstruktor klasy.
   * @param $pServerName Nazwa serwera.
   * @param $pUserNname Nazwa u¿ytkownika.
   * @param $pPassword Has³o.
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
   * Metoda do otwarcia po³¹czenia z serweram bazy danych.
   * @return obiekt PDO z aktywnym po³¹czeniem lub '%' je¿eli nie uda³o siê nawi¹zaæ po³¹czenia
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
   * Metoda do wywo³ania polecenia INSERT w bazie danych
   * @param $connection obiekt PDO z aktywnym po³¹czeniem
   * @param $statement Polecenie SQL typu INSERT
   * @return identyfikator wprowadzonego rekordu lub '%' je¿eli wyst¹pi³ b³¹d
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
   * Metoda do wywo³ania polecenia SELECT na wielu rekordach
   * @param $connection obiekt PDO z aktywnym po³¹czeniem
   * @param $statement Polecenie SQL typu SELECT
   * @return tablica z rekordami zwróconymi przez zapytanie lub '%' je¿eli wyst¹pi³ b³¹d
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
 * Metoda do wywo³ania polecenia SELECT pobieraj¹ca jeden rekord
 * @param $connection obiekt PDO z aktywnym po³¹czeniem
 * @param $statement Polecenie SQL typu SELECT
 * @return tablica z rekordem zwróconym przez zapytanie lub '%' je¿eli wyst¹pi³ b³¹d
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
 * Metoda do sprawdzenia liczby wników zapytnia SQL
 * @param $connection obiekt PDO z aktywnym po³¹czeniem
 * @param $statement Polecenie SQL
 * @return liczba wyników lub '%' je¿eli wyst¹pi³ b³¹d
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
