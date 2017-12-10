<?php
class DomDataLoader{
  public static function loadData($address){

    $dom = new DOMDocument('1.0', 'utf-8');

    // There is bunch of warnings if you get rid of this @ 'at' sign
    @$dom->loadHTMLFile($address);

    return $dom;


  //  $file = file_get_contents($address) or die("Error: Cannot create object");
  //  return $file;


}
}


?>
