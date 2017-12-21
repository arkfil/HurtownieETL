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
    echo '{
        "status":"ok",
        "object-type:":"rough-html",
        "element_id":"'.$_GET['id'].'",
        "data":"'.urlencode($data[0]->saveHTML($data[0])).'"
      }';
  }
}else if($_GET['purpose']=='T'){
  // if($_SERVER["REQUEST_METHOD"]=="PUT"){
  //   // parse_str(file_get_contents("php://input"),$post_vars);
  //   $tHndl = new TransformHandler;
  //   // echo json_decode(file_get_contents("php://input"),false)->data;
  //   $rawCode = json_decode(file_get_contents("php://input"),false)->data;
  //   $domDataLoader = new DomDataLoader();
  //
  //
  //   $prId = json_decode(file_get_contents("php://input"),false)->element_id;
  //   echo "{".
  //     '"status":"ok",'.
  //     '"element_id":"'.$prId.'",'.
  //     '"object-type":"product",'.
  //     '"data":'.$tHndl->transformData($domDataLoader.load($rawCode),$prId).'}';
  // }else{
  //   return 'error';
  // }
  // //TO DO
  if(!empty($_GET['id'])){
    $eh = new ExtractHandler;
    $data =  $eh->extractData($_GET['id']);
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

    $rawCode = json_decode(file_get_contents("php://input"),false)->data;
    $prId = json_decode(file_get_contents("php://input"),false)->element_id;

    echo "{".
      '"status":"ok",'.
      '"element_id":"'.$prId.'",'.
      '"object-type":"information",'.
      '"data":{"status":"ok","description":"Process ended successfully"}}';
  }else{
    return 'error';
  }
}else{
  echo '{"status":"error","object-type":"error-details","data":{"error-code":1,"description":"Something is wrong with url address"}}';
}






 ?>
