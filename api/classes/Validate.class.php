<?php
require_once("classes/Resoponse.class.php");
class Validate{
	private $response;
	public $missingArgs = array();

	function __construct(){
		$this->response = new Response();
		// $this->args = $args;
		// $this->allowedArgs = $allowedArgs;
	}
	public function validateArgs($args, $allowedArgs){
		foreach($allowedArgs as $arg => $argConf){
			$this->checkRequiredArgs($args, $arg, $argConf);
			// $this->validateType($arg, $argConf);
			// if(isset($argConf['type']) && $argConf['type'] == 'array'){
			// 	$this->validateArgs()
			// }

			// if(isset($argConf['type']) && $argConf['type'] == 'array'){
				// print_r($args[$arg]);
			// }
		}
		if(count($this->missingArgs) > 0){
			$this->response->addError($this->missingArgs);
			$this->response->setGeneralMsg("Missing required Arguments");
		}
		return $this->response;
	}
	private function validateType($arg){
		if(isset($argConf['type']) && $argConf['type']){
			$type = $argConf['type'];
			if($type == 'array'){
				// print_r($arg);
			// 	foreach($arg as $key => $value){
			// 		$this->validateArgs($args, $value);
			}
			// }
		}
	}
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