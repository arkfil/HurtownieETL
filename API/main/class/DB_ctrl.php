<?php

class DB_ctrl{
  private $db;
  private $connection;
  function __construct(){
    $this->db = new DB("localhost","user","password","ceneo_etl");
    $this->connection = $this->db->connect();
  }

  public function getWholeProduct($prId){
    $wholePr = $this->db->selectAllNumberIndexed($this->connection,"SELECT * FROM products
    LEFT JOIN remarks ON pr_id = rem_pr_id AND pr_lp = rem_pr_lp
    LEFT JOIN opinions ON pr_id = op_pr_id AND pr_lp = op_pr_lp
    LEFT JOIN opinions_features ON op_id = opfea_op_id AND op_pr_lp = opfea_pr_lp
    LEFT JOIN features ON opfea_fea_id = fea_id
    WHERE pr_id = $prId AND pr_lp = (SELECT pr_lp FROM products where pr_id = $prId ORDER BY pr_lp DESC LIMIT 1)");
    return $wholePr;
  }

  public function getProduct($prId){
    $prAssoc = $this->db->selectWhole($this->connection,"SELECT * FROM products WHERE pr_id = '$prId' ORDER BY pr_lp DESC LIMIT 1");
    $prAssoc = $prAssoc[0];
    $prObject = new Product($prId, $prAssoc["pr_type"], $prAssoc["pr_brand"], $prAssoc["pr_model"], array(), array());
    $prLp = $prAssoc['pr_lp'];
    $prObject->setOpinions($this -> getOpinionsArray($prId,$prLp));
    $prObject -> setRemarks($this -> getProductRemarksArray($prId, $prLp));

    return $prObject;
  }

  public function getLatestProductsLp($prId){
    $prAssoc = $this->db->selectWhole($this->connection,"SELECT * FROM products WHERE pr_id = '$prId' ORDER BY pr_lp DESC LIMIT 1");
    $prAssoc = $prAssoc[0];
    return $prAssoc["pr_lp"];
  }

  public function getOpinionsArray($prId,$prLp){
    $opsAssoc = $this->db->selectWhole($this->connection, "SELECT * FROM opinions WHERE op_pr_id = '$prId' AND op_pr_lp = '$prLp' ORDER BY op_date DESC");
    $opObjArr = array();

    $currOp;
    $currOpID;
    for($i=0;$i<sizeof($opsAssoc);++$i){

      $currOp = $opsAssoc[$i];
      $currOpID = $currOp['op_id'];

      $feaObjArr = $this -> getFeaturesArray($currOpID,$prLp);

      $opObjArr[] = new Opinion($currOpID, rawurlencode($currOp["op_date"]), $currOp["op_summary"], $currOp["op_stars"], $currOp["op_author"],
                              $currOp["op_is_positive"], $currOp["op_up_votes_count"], $currOp["op_down_votes_count"], $feaObjArr);
    }

    return $opObjArr;
  }

  public function getFeaturesArray($opId,$prLp){
    $feaObjArr = array();
    $feasAssoc = $this->db->selectWhole($this->connection,
      "SELECT * FROM opinions_features JOIN features ON opfea_fea_id = fea_id WHERE opfea_op_id='$opId' AND opfea_pr_lp = '$prLp'");

    for($g=0;$g<sizeof($feasAssoc);++$g){
      $feaObjArr[] = new Feature($feasAssoc[$g]["fea_name"],$feasAssoc[$g]["fea_is_adv"]);
    }
    return $feaObjArr;
  }

  public function getProductRemarksArray($prId, $prLp){
    $remObjArr = array();
    $remAssoc = $this->db->selectWhole($this->connection, "SELECT * FROM remarks WHERE rem_pr_id = '$prId' AND rem_pr_lp = '$prLp'");
    for($i=0;$i<sizeof($remAssoc);++$i){
      $remObjArr[] = new Remark($remAssoc[$i]["rem_name"]);
    }
    return $remObjArr;
  }


  public function isProductInDB($prId){
      return $this->db->checkOccurenceCount($this->connection,"SELECT count(*) FROM products WHERE pr_id = '$prId'");
  }

  public function saveProductInfo($id,$lp,$type,$brand,$model){
      $this->db->insertStatement($this->connection,"INSERT INTO products VALUES('$id','$lp',".$this->connection->quote($type).",".$this->connection->quote($brand).",".$this->connection->quote($model).")");
  }

  public function saveRemarks($remarksArr,$prId,$prLp){
      $remName;
      foreach($remarksArr as $remark) {
        $remName = $remark->getName();
        $this->db->insertStatement($this->connection,"INSERT INTO remarks VALUES('null',".$this->connection->quote($remName).",'$prId','$prLp')");
      }
  }

  public function saveOpinions($opinionsArr,$prId,$prLp){

      foreach($opinionsArr as $opinion) {
        $opDate = urldecode($opinion->getDate());

        $opId = $opinion->getId();
        $opSum = $opinion->getSummary();
        $opSarsCount = $opinion->getStars();

        $opAuthor = $opinion->getAuthor();
        $opIsPos = $opinion->getIsPositive();
        $opUpVotes = $opinion->getUpVotesCount();
        $opDownVotes = $opinion->getDownVotesCount();
        $opFeaturesArr = $opinion->getFeatures();

        $stmnt = "INSERT INTO opinions VALUES('$opId','$prId','$prLp','$opDate',".$this->connection->quote($opSum);
        $stmnt = $stmnt.",'$opSarsCount',".$this->connection->quote($opAuthor).",'$opIsPos','$opUpVotes','$opDownVotes')";
        $this->db->insertStatement($this->connection,$stmnt);

        $this -> saveFeatures($opFeaturesArr,$opId, $prLp);
      }
  }

  public function disconnect(){
    $this->connection = null;
  }
  private function saveFeatures($featyresArr,$opId, $prLp){
    foreach($featyresArr as $feature) {
      $feaIsAdv = $feature->getIsAdv();
      $feaSummary = $feature->getName();

      $feaId = $this->db->insertStatement($this->connection,"INSERT INTO features VALUES('null',".$this->connection->quote($feaSummary).",'$feaIsAdv')");

      $rel = $this->db->insertStatement($this->connection,"INSERT INTO opinions_features VALUES('$opId','$prLp','$feaId')");
    }
  }

  public function cacheProductHtml($domArr){
    $productPage = $this->connection->quote($domArr[0]->saveHTML($domArr[0]));
    $cachedId = $this->db->insertStatement($this->connection,"INSERT INTO cached_html_products VALUES('null',$productPage)");

    for($i=1; $i<sizeof($domArr); ++$i){
      $opinionsPage = $this->connection->quote($domArr[$i]->saveHTML($domArr[$i]));
      $this->db->insertStatement($this->connection,"INSERT INTO cached_html_opinions VALUES('null',$cachedId,$opinionsPage)");
    }

    return $cachedId;
  }

  public function retriveCachedRawData($inCacheId){
    $data = array();
    $dom = new DOMDocument('1.0', 'utf-8');

    $dataAssoc = $this->db->selectWhole($this->connection, "SELECT * FROM cached_html_products WHERE cp_id = '$inCacheId' LIMIT 1");
    @$dom->loadHTML($dataAssoc[0]["cp_data"]);
    $data[] = $dom;

    $cachePrId = $dataAssoc[0]["cp_id"];

    $dataAssoc = $this->db->selectWhole($this->connection, "SELECT * FROM cached_html_opinions WHERE op_cp_id = '$cachePrId'");
    // print_r($dataAssoc);
    foreach($dataAssoc as $opinionPageDom) {

      $dom = new DOMDocument('1.0', 'utf-8');
      @$dom->loadHTML($opinionPageDom["co_data"]);
      $data[] = $dom;
    }
    return $data;
  }




}

?>
