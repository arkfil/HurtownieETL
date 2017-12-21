<?php

class DB_ctrl{
  private $db;
  private $connection;
  function __construct(){
    $this->db = new DB("localhost","user","password","ceneo_etl");
    $this->connection = $this->db->connect();
  }

  public function isProductInDB($prId){
      return $this->db->checkOccurenceCount($this->connection,"SELECT count(*) FROM products WHERE pr_id = '$prId'");
  }

  public function saveProductInfo($id,$type,$brand,$model){
      $this->db->insertStatement($this->connection,"INSERT INTO products VALUES('$id','$type','$brand','$model')");
  }

  public function saveRemarks($remarksArr,$prId){
      $remName;
      foreach($remarksArr as $remark) {
        $remName = $remark->getName();
        $this->db->insertStatement($this->connection,"INSERT INTO remarks VALUES('null','$prId','$remName')");
      }
  }

  public function saveOpinions($opinionsArr,$prId){

      foreach($opinionsArr as $opinion) {
        $opDate = $opinion->getDate();

        $opId = $opinion->getId();
        $opSum = $opinion->getSummary();
        $opSarsCount = $opinion->getStars();

        $opAuthor = $opinion->getAuthor();
        $opIsPos = $opinion->getIsPositive();
        $opUpVotes = $opinion->getUpVotesCount();
        $opDownVotes = $opinion->getDownVotesCount();
        $opFeaturesArr = $opinion->getFeatures();

        $this->db->insertStatement($this->connection,"INSERT INTO opinions VALUES('$opId','$prId','$opDate','$opSum','$opSarsCount','$opAuthor','$opIsPos','$opUpVotes','$opDownVotes')");

        $this -> saveFeatures($opFeaturesArr,$opId);
      }
  }

  public function disconnect(){
    $this->connection = null;
  }
  private function saveFeatures($featyresArr,$opId){
    foreach($featyresArr as $feature) {
      $feaIsAdv = $feature->getIsAdv();
      $feaSummary = $feature->getName();

      $feaId = $this->db->insertStatement($this->connection,"INSERT INTO features VALUES('null','$feaSummary','$feaIsAdv')");

      $rel = $this->db->insertStatement($this->connection,"INSERT INTO opinions_features VALUES('$opId','$feaId')");
    }
  }




}

?>
