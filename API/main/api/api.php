<?php
header('Content-type:application/json;charset=utf-8');
if($_GET['purpose']=='ETL'){
  if(!empty($_GET['id'])){
    $ETLHndl = new ETLProcessHandler;
    $productObj = $ETLHndl->start($_GET['id']);
    echo "{".
      '"status":"ok",'.
      '"element_id":"'.$_GET['id'].'",'.
      '"object-type":"product",'.
      '"data":'.$productObj.'}';
  }else{
    echo 'error';
  }
}else if($_GET['purpose']=='E'){
  if(!empty($_GET['id'])){
    $eh = new ExtractHandler;
    $data =  $eh->extractData($_GET['id']);

    $dbCtrl = new DB_ctrl();
    $cachedId = $dbCtrl->cacheProductHtml($data);
    $dbCtrl->disconnect();
    echo '{
        "status":"ok",
        "object-type":"information",
        "cached_rough_data_id":"'.$cachedId.'",
        "element_id":"'.$_GET['id'].'",
        "data":{"status":"ok","description":"Process ended successfully"}
      }';
  }
}else if($_GET['purpose']=='T'){

    if(!empty($_GET['id']) && !empty($_GET['data'])){
    // $eh = new ExtractHandler;
    // $data =  $eh->extractData($_GET['id']);

    $dbCtrl = new DB_ctrl();
    $data = $dbCtrl->retriveCachedRawData($_GET['data']);
    $dbCtrl->disconnect();

    $tr = new TransformHandler;
    $productObj = $tr->transformData($data,$_GET['id']);

    echo "{".
      '"status":"ok",'.
      '"element_id":"'.$_GET['id'].'",'.
      '"object-type":"product",'.
      '"data":'.$productObj.'}';
  }

}else if($_GET['purpose']=='L'){
  if($_SERVER["REQUEST_METHOD"]=="PUT"){

    $prJSON = json_decode(file_get_contents("php://input"),false)->data;
    $prId = json_decode(file_get_contents("php://input"),false)->element_id;

    $productObj = new Product($prId,$prJSON->type,$prJSON->brand,$prJSON->model,array(),array());

    $opObjArr = array();

    $opJsonArr = $prJSON->opinions;
    for($k=0;$k<sizeof($opJsonArr);++$k){
      $feaObjArr = array();
      $feaJsonArr = ($prJSON->opinions)[$k]->advantages;
      for($l=0;$l<sizeof($feaJsonArr);++$l){
        $feaObjArr[] = new Feature($feaJsonArr[$l],1);
      }
      $feaJsonArr = ($prJSON->opinions)[$k]->disadvantages;
      for($l=0;$l<sizeof($feaJsonArr);++$l){
        $feaObjArr[] = new Feature($feaJsonArr[$l],0);
      }

      $opObjArr[] = new Opinion($opJsonArr[$k]->id,$opJsonArr[$k]->date,$opJsonArr[$k]->summary,$opJsonArr[$k]->stars,$opJsonArr[$k]->author,
                      $opJsonArr[$k]->positive,$opJsonArr[$k]->{'up-votes'},$opJsonArr[$k]->{'down-votes'},$feaObjArr);
      // $pId, $pDate, $pSummary, $pStars, $pAuthor, $pIsPositive, $pUpVotesCount, $pDownVotesCount, $pFeatures
    }
    $productObj->setOpinions($opObjArr);

    $remJsonArr = $prJSON->remarks;
    $remObjArr = array();
    for($k=0;$k<sizeof($remJsonArr);++$k){
      $remObjArr[] = new Remark($remJsonArr[$k]->name);
    }

    $productObj->setRemarks($remObjArr);

    $ld = new LoadHandler;
    $ld->loadData($productObj);
    echo "{".
      '"status":"ok",'.
      '"element_id":"'.$prId.'",'.
      '"object-type":"product",'.
      '"data":'.$productObj.'}';
    // echo "{".
    //   '"status":"ok",'.
    //   '"element_id":"'.$prId.'",'.
    //   '"object-type":"information",'.
    //   '"data":{"status":"ok","description":"Process ended successfully"}}';
  }else{
    return 'error';
  }
}else{
  echo '{"status":"error","object-type":"error-details","data":{"error-code":1,"description":"Something is wrong with url address"}}';
}






 ?>
