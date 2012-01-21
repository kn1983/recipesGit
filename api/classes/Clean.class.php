<?php
class Clean{
	function __construct(){
	}
	public static function cleanArg($arg){
		$arg = strip_tags($arg);
		$arg = mysql_real_escape_string($arg);
		$arg = utf8_decode($arg);
		return $arg;
	}
	public static function cleanOutput($array){
		$cleanArray = "";
		foreach($array as $key => $value){
			$cleanArray[$key] = strip_tags($value);
			$cleanArray[$key] = utf8_encode($value);
		}
		return $cleanArray;
	}
}
?>