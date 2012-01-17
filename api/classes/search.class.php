<?php
require_once('classes/Resoponse.class.php');
class _search{
	private $response;
	function __construct(){
		$this->response = new Response();
	}
	public function searchRecipe($args){
		$this->response->addData('test', $args);
		return $this->response;
	}	
}
?>