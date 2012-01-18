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
	public static function utf8Encode($array){
		$utf8Array = "";
		foreach($array as $key => $value){
			$utf8Array[$key] = utf8_encode($value);
		}
		return $utf8Array;
	}
}
?>