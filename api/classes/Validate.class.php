<?php
require_once("classes/Resoponse.class.php");
class Validate{
	private $response;
	public $missingArgs = array();
	private $wrongType = array();

	function __construct(){
		$this->response = new Response();
	}

	//validate arguments
	public function validateArgs($args, $allowedArgs){
		foreach($allowedArgs as $arg => $argConf){
			$this->checkRequiredArgs($args, $arg, $argConf);
		}
		if(count($this->missingArgs) > 0){
			$this->response->addError($this->missingArgs);
			$this->response->setGeneralMsg("Missing required Arguments");
		}
		return $this->response;
	}

	//Check if required arguments exist
	private function checkRequiredArgs($args, $arg, $argConf){
		if(isset($argConf['required']) && $argConf['required']){
		    if(!isset($args[$arg]) || !$args[$arg]){
		        $this->missingArgs[] = $arg; 
		    }
		}
	}

	//Validate email
	public function email($email){
		return preg_match('/^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/', $email);
	}
}
?>