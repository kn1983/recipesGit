<?php
class Clean{
	function __construct(){
	}
	public static function cleanArg($arg){
		$arg = strip_tags($arg);
		$arg = mysql_real_escape_string($arg);
		return $arg;
	}
}
?>