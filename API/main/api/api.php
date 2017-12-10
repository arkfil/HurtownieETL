<?php
header('Content-type:application/json;charset=utf-8');
if($_GET['purpose']=='ETL'){
  if(!empty($_GET['id'])){
    $ETLHndl = new ETLProcessHandler;
    echo $ETLHndl->start($_GET['id']);
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
        "data":"'.urlencode($data[0]->saveHTML($data[0])).'"
      }';
  }
}else if($_GET['purpose']=='T'){

  //TO DO

}else if($_GET['purpose']=='L'){

  // TO DO

}else{
  echo '{"status":"error","object-type":"error-details","data":{"error-code":1,"description":"Something is wrong with url address"}}';
}






 ?>
