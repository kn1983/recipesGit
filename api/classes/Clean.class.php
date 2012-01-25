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
	public static function executeQueryAndCleanResult($query, $limit){
		$result = mysql_query($query) or die(mysql_error());
		$rowsLen = mysql_num_rows($result);
		if($result && $rowsLen > 0){
			if($limit){
				$row = mysql_fetch_assoc($result);
				$ret = self::cleanOutput($row);
			} else {
				$ret = array();
				while($row = mysql_fetch_assoc($result)){
					$ret[] = self::cleanOutput($row);
				}
			}
			return $ret;
		} else {
			return false;
		}
	}
}
?>