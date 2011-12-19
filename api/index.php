<?php
require_once "classes/DbLogin.class.php";
session_start();
$dbLogin = new DbLogin();

$actions = parseURLtoActions();
$format = array_shift($actions);
 
if($format == "docs"){
  require_once("printDocs.php");
  printDocs();
}else{
  require_once("api.php");
  runAPI($format, $actions);
}
 
// returns the Actions in an array
function parseURLtoActions(){
  $getkeys = array_keys($_GET);
  $action_parts = explode('/',$getkeys[0]);
 
  foreach($action_parts as $part){
    if($part != ""){
      $actions[] = $part;
    }
  }
  return $actions;
}
?>