<?php
class Validate{
	private $allowedArgs;
	private $args;
	function __construct($allowedArgs, $args){
		$this->allowedArgs = $allowedArgs;
		$this->args = $args;
	}
	public function validateArgs(){
		$missingArgs = array();
		foreach($this->allowedArgs as $arg => $argConf){
	     	if(isset($argConf['required']) && $argConf['required']){
		        if(!isset($this->args[$arg]) || !$this->args[$arg]){
		          $missingArgs[] = $arg;
		        }else{
		          // $cleanArgs[$arg] = $args[$arg];
		        }
	      	}else{
	        	if(isset($this->args[$arg])){
	        		
	        	}
	          // $cleanArgs[$arg] = $args[$arg];
	      	}
	    }
	    return $missingArgs;
	}
	private function argExist($arg, $argConf){
	}
}
?>