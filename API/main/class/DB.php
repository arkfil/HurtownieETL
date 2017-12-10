<?php

class DB{
  private const SERVERNAME = "localhost";
  private const USERNAME = "user";
  private const PASSWORD = "password";

  private static function connect(){
    try {
      $connection = new PDO("mysql:host=".self::SERVERNAME.";dbname=note_db", self::USERNAME, self::PASSWORD);
      // set the PDO error mode to exception
      $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $connection;
    }catch(PDOException $e){
      // return $e->getMessage();
      return "%";
    }
  }
  private static function insertStatement($connection, $statement){
    try {
      $connection->exec($statement);
      return $connection->lastInsertId();
    }catch(PDOException $e){
      return "%";
    }
  }
  private static function selectWhole($connection, $statement){
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
private static function selectOne($connection, $statement){
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
private static function checkOccurenceCount($connection, $statement){
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
