<?php
function runAPI($format, $actions){
  require_once('objects.conf.php');
  require_once('classes/Validate.class.php');
  require_once('classes/Resoponse.class.php');
  $response = new Response();
  $object_name = array_shift($actions);
  $method_name = array_shift($actions);
  $args = $_POST;
 
  if(in_array($object_name, array_keys($_OBJECTS))){
    $allowedArgs = $_OBJECTS[$object_name]['methods'][$method_name]['args'];
    $validate = new Validate();
    $return = $validate->validateArgs($args, $allowedArgs);
    
    if(!$return->checkSuccess()){
       echo $return->output();
    } else {
      require_once("classes/".$object_name.".class.php");
      $object_name = "_".$object_name;
      $object = new $object_name();
      if(method_exists($object,$method_name)){
        $return = $object->$method_name($args);
        echo $return->output();
      }else{
        echo "Method $method_name does not exist in $object_name!";
      }
    }
  }else{
    $response->addError($object_name, 'Object is not allowed!');
  }
}
?>