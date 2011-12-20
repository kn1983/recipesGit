<?php
function runAPI($format, $actions){
  require_once("objects.conf.php");
  $object_name = array_shift($actions);
  $method_name = array_shift($actions);
  $args = $_POST;

  //Check if object exist in $_OBJECTS aray
  if(in_array($object_name, array_keys($_OBJECTS))){
    $allowed_args = $_OBJECTS[$object_name]['methods'][$method_name]['args'];
    $missing_args = array();
    $clean_args = array();
    $invalid_type = array();
    $validArgs = true;

    //Check if the arguments are allowed
    foreach($allowed_args as $arg => $arg_conf){
      $type = argType($arg_conf);

      //Adds the arguments that are missing to an array
      if(isset($arg_conf['required']) && $arg_conf['required']){
        if(!isset($args[$arg]) || !$args[$arg]){
          $missing_args[] = $arg;
        }else{
          $clean_args[$arg] = $args[$arg];
        }
      }else{
        if(isset($args[$arg])){
          $clean_args[$arg] = $args[$arg];
        }
      }
    }

    //Check if argument type is valid
    foreach($clean_args as $key => $val){
      $type = $_OBJECTS[$object_name]['methods'][$method_name]['args'][$key]['type'];
      if(!validateType($val, $type)){
        $invalid_type[] = $key;
      }
    }

    //Prints the arguments that are missing
    if(count($missing_args) > 0 ){
      echo "Missing required arguments!";
      print_r($missing_args);
      $validArgs = false;
    }

    //Prints the arguments that have invalid type
    if(count($invalid_type) > 0 ){
      echo "Wrong type!";
      print_r($invalid_type);
      $validArgs = false;
    }

    //Executes the method in the class if the arguments are valid
    if($validArgs) {
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

//Sets the type
function argType($arg_conf){
  if(isset($arg_conf['type']) && $arg_conf['type']){
    return $arg_conf['type'];
  } else {
    return false;
  }
}

//Validate the type for the arguments
function validateType($arg, $type){
  if ($type == 'numeric'){
    return is_numeric($arg);
  } else if($type == 'string'){
    return is_string($arg);
  } else {
    return true;
  }
}

//Output json or text
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