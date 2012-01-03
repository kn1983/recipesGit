<?php
require_once("classes/Resoponse.class.php");
class _units{
	private $response;
	function __construct(){
		$this->response = new Response();
	}
	public function get($args){
		$query = "SELECT id, name FROM units";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result)>0){
			$units = array();
			while($row = mysql_fetch_assoc($result)){
				$units[] = $row;
			}
			$this->response->addData('units', $units);
			return $this->response;
		}
	}	
}
?>