<?php

class DB{
  private $serverName;
  private $userNname;
  private $password;
  private $dbName;

  function __construct($pServerName,$pUserNname,$pPassword,$pDbName){
    $this->serverName=$pServerName;
    $this->userNname=$pUserNname;
    $this->password=$pPassword;
    $this->dbName = $pDbName;
  }



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
  public function insertStatement($connection, $statement){
    try {
      $connection->exec($statement);
      return $connection->lastInsertId();
    }catch(PDOException $e){
      return "%";
    }
  }
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
