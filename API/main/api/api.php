<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

if($_GET['purpose']=='etl'){
  header('Content-type:application/json;charset=utf-8');

  if(!empty($_GET['id'])){
    $ETLHndl = new ETLProcessHandler;
    $productObj = $ETLHndl->start($_GET['id']);
    echo "{".
      '"status":"ok",'.
      '"element_id":"'.$_GET['id'].'",'.
      '"object_type":"product",'.
      '"product_data":'.$productObj.'}';
  }else{
    echo 'error';
  }
}else if($_GET['purpose']=='e'){
  header('Content-type:application/json;charset=utf-8');

  if(!empty($_GET['id'])){
    $eh = new ExtractHandler;
    $data =  $eh->extractData($_GET['id']);

    $dbCtrl = new DB_ctrl();
    $cachedId = $dbCtrl->cacheProductHtml($data);
    $dbCtrl->disconnect();
    echo '{
        "status":"ok",
        "object_type":"information",
        "cached_rough_data_id":"'.$cachedId.'",
        "element_id":"'.$_GET['id'].'",
        "product_data":{"status":"ok","description":"Process ended successfully"}
      }';
  }
}else if($_GET['purpose']=='t'){
  header('Content-type:application/json;charset=utf-8');

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
      '"product_data":'.$productObj.'}';
  }

}else if($_GET['purpose']=='l'){
  header('Content-type:application/json;charset=utf-8');

  if($_SERVER["REQUEST_METHOD"]=="PUT"){

    $prJSON = json_decode(file_get_contents("php://input"),false)->product_data;
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
                      $opJsonArr[$k]->positive,$opJsonArr[$k]->{'up_votes'},$opJsonArr[$k]->{'down_votes'},$feaObjArr);
      // $pId, $pDate, $pSummary, $pStars, $pAuthor, $pIsPositive, $pUpVotesCount, $pDownVotesCount, $pFeatures
    }
    $productObj->setOpinions($opObjArr);

    $remJsonArr = $prJSON->remarks;
    $remObjArr = array();
    for($k=0;$k<sizeof($remJsonArr);++$k){
      $remObjArr[] = new Remark($remJsonArr[$k]);
    }

    $productObj->setRemarks($remObjArr);

    $ld = new LoadHandler;
    $ld->loadData($productObj);
    echo "{".
      '"status":"ok",'.
      '"element_id":"'.$prId.'",'.
      '"object_type":"product",'.
      '"product_data":'.$productObj.'}';
    // echo "{".
    //   '"status":"ok",'.
    //   '"element_id":"'.$prId.'",'.
    //   '"object-type":"information",'.
    //   '"data":{"status":"ok","description":"Process ended successfully"}}';
  }else{
    return 'error';
  }
}else if($_GET['purpose']=='csv'){
  if(!empty($_GET['id'])){
    $dbCtrl = new DB_ctrl();
    $prArr = $dbCtrl->getWholeProduct($_GET['id']);

    foreach ($prArr as &$line) {
      foreach ($line as &$item) {
        $item = rawurldecode($item);
      }
    }

    $temp_memory = fopen('php://memory', 'w');
    fputs($temp_memory, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
    fputs($temp_memory,"sep=,\n");
    foreach ($prArr as $line) {
      fputcsv($temp_memory, $line, ',');
    }

    fseek($temp_memory, 0);
    header('Content-Type: application/csv;charset=utf-8');
    header('Content-Disposition: attachement; filename="product_' . $_GET['id'] . '.csv";');

    fpassthru($temp_memory);
  }else{
    echo 'error';
  }
}else{
  echo '{"status":"error","object_type":"error_details","data":{"error_code":1,"description":"Something is wrong with url address"}}';
}






 ?>
