<?php
 
function printDocs(){
  require_once('objects.conf.php');
 
  foreach($_OBJECTS as $obj => $obj_info){
 
    if(file_exists("classes/".$obj.".class.php"))
        $color = "green";
      else
        $color = "red";
 
    echo "<h2 style='color: $color;'>$obj</h2>";
    echo "<p>{$obj_info['description']}</p>";
    echo "<table>";
    echo "<tr><td>Method</td><td>Description</td><td>Arguments</td></tr>";
    foreach($obj_info['methods'] as $func => $func_spec){
 
      if(file_exists("classes/".$obj.".class.php")){
        require_once("classes/".$obj.".class.php");
        $obj_name = "_".$obj;
        $object = new $obj_name();
        if(method_exists($object, $func))
          $color = "green";
        else
          $color = "red";
      }
 
      echo "<tr style='background: $color;'>";
        echo "<td>{$func}</td>";
        echo "<td>{$func_spec['description']}</td>";
        $args = implode(', ',array_keys($func_spec['args']));
        echo "<td>{$args}</td>";
      echo "</tr>";
    }
    echo "</table>";
  }
}
 
?>