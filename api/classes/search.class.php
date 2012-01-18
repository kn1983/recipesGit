<?php
require_once('classes/Resoponse.class.php');
require_once('classes/Clean.class.php');
class _search{
	private $response;
	function __construct(){
		$this->response = new Response();
	}
	public function searchAll($args){
		// $searchStr = Clean::cleanArg($args['searchStr']);
		// $searchArray = explode(',', $searchStr);

		// for($i = 0; $i < count($searchArray); $i++){
		// 	$this->checkIfCategory($searchArray[$i]);
		// }

		// $this->response->addData('test', $searchArray);
		// return $this->response;
	}	

	// private function checkIfCategory($searchStr){
	// 	$query = "SELECT id, category FROM categories
	// 			  WHERE category='{$searchStr}'";
	// 	$result = $
	// }
}
?>