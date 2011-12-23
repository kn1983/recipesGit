<?php
require_once("classes/Resoponse.class.php");
class Validate{
	private $response;
	private $args;
	private $allowedArgs = array();
	public $missingArgs = array();

	function __construct($args, $allowedArgs){
		$this->response = new Response();
		$this->args = $args;
		$this->allowedArgs = $allowedArgs;
	}
	public function validateArgs(){
		foreach($this->allowedArgs as $arg => $argConf){
			$this->checkRequiredArgs($arg, $argConf);
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
	private function checkRequiredArgs($arg, $argConf){
		if(isset($argConf['required']) && $argConf['required']){
		    if(!isset($this->args[$arg]) || !$this->args[$arg]){
		        $this->missingArgs[] = $arg; 
		    }
		}
	}
	private function validateStrin(){
		
	}
}
?>