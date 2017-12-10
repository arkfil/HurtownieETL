<?php

  Route::set('index.php', function(){
    View_ctrl::createView("view");
  });
  Route::set('api', function(){
    Api_ctrl::createView('api');
  });


 ?>
