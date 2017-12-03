<?php
echo "
{
 lp: 0,
 status: 'ok'
}
";






if($_GET['purpose']=='ETL'){
  if(!empty($_GET['id'])){
    $ETLHndl = new ETLProcessHandler;
    echo $ETLHndl->start($_GET['id']);
  }else{
    echo 'error';
  }

}else if($_GET['purpose']=='T'){

  //TO DO

}else if($_GET['purpose']=='L'){

  // TO DO

}else{
  echo 'error';
}






 ?>
