<?php
require_once('classes/Resoponse.class.php');
class Validate{
	private $response;
	public $missingArgs = array();
	private $wrongType = array();
	private $invalidLen = array();

	function __construct(){
		$this->response = new Response();
	}

	//validate arguments
	public function validateArgs($args, $allowedArgs){
		foreach($allowedArgs as $arg => $argConf){
			$this->checkRequiredArgs($args, $arg, $argConf);

			if(isset($args[$arg]) && $args[$arg]){
				$this->validateType($args, $arg, $argConf);
				$this->validateLength($args, $arg, $argConf);
			}
		}
		if(count($this->missingArgs) > 0){
			$this->response->addError($this->missingArgs);
			$this->response->setGeneralMsg("Missing required Arguments!");
			return $this->response;
		}
		if(count($this->wrongType) > 0){
			$this->response->addError($this->wrongType);
			$this->response->setGeneralMsg("The arguments have wrong types");
			return $this->response;	
		}
		if(count($this->invalidLen) > 0){
			$this->response->addError($this->invalidLen);
			$this->response->setGeneralMsg("The arguments have invalid length");
			return $this->response;		
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
	private function validateType($args, $arg, $argConf){
		if(isset($argConf['type'])){
			$type = $argConf['type'];
			if($type == 'string'){
				if(!is_string($args[$arg])){
					$this->wrongType[] = $arg;
				}
			} else if($type == 'numeric'){
				if(!is_numeric($args[$arg])){
					$this->wrongType[] = $arg;
				}
			}
		}
	}
	private function validateLength($args, $arg, $argConf){
		if(isset($argConf['maxlen']) && $argConf['maxlen']){
			$maxLen = $argConf['maxlen'];
			$strLen = strlen($args[$arg]);
			if($strLen > $maxLen){
				$this->invalidLen[] = $arg;
			}
		}
	}
	//Validate email
	public function email($email){
		return preg_match('/^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/', $email);
	}
}
?>