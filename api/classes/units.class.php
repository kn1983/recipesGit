<?php
require_once('classes/Resoponse.class.php');
require_once('classes/Clean.class.php');
class Units{
	private $response;
	function __construct(){
		$this->response = new Response();
	}
	
	public function get($args){
		$units = $this->getUnits($args);
		if($units){
			$this->response->addData('units', $units);
		} else {
			$this->response->addError("Kunde inte hämta enheterna!");
		}
		return $this->response;
	}

	public function getUnits($args){
		$query = "SELECT id, name FROM units";
		$cleanResult = Clean::executeQueryAndCleanResult($query, false);
		if($cleanResult){
			return $cleanResult;
		} else {
			return false;
		}
	}
}
?>