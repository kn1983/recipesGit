<?php
function runAPI($format, $actions){
  require_once("objects.conf.php");
  require_once("classes/Validate.class.php");
  $object_name = array_shift($actions);
  $method_name = array_shift($actions);
  $args = $_POST;
 
  if(in_array($object_name, array_keys($_OBJECTS))){
    $allowedArgs = $_OBJECTS[$object_name]['methods'][$method_name]['args'];
    // $missing_args = array();
    $clean_args = array();
    
      $validate = new Validate($allowedArgs, $args);
      $missingArgs = $validate->validateArgs();

    // foreach($allowed_args as $arg => $arg_conf){
    //   if(isset($arg_conf['required']) && $arg_conf['required']){
    //     if(!isset($args[$arg]) || !$args[$arg]){
    //       $missing_args[] = $arg;
    //     }else{
    //       $clean_args[$arg] = $args[$arg];
    //     }
    //   }else{
    //     if(isset($args[$arg]))
    //       $clean_args[$arg] = $args[$arg];
    //   }
    // }
    if(count($missingArgs) > 0){
      echo "Missing required arguments!";
      print_r($missingArgs);
    }else{
      $args = $clean_args;
      require_once("classes/".$object_name.".class.php");
 
      $object_name = "_".$object_name;
 
      $object = new $object_name();
 
      if(method_exists($object,$method_name)){
        $return = $object->$method_name($args);
        output($return,$format);
      }else{
        echo "Method $method_name does not exist in $object_name!";
      }
    }
  }else{
    echo "Object is not allowed!";
  }
}
 
function output($data, $format = 'json'){
  switch($format){
    case 'json':
      echo json_encode($data);
      break;
    case 'text':
      echo "<pre>";
      print_r($data);
      echo "</pre>";
      break;
    default:
      echo "No valid format selected!";
  }
}
?>