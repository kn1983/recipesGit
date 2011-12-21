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
		foreach($this->allowed_args as $arg => $arg_conf){
	      if(isset($arg_conf['required']) && $arg_conf['required']){
	        if(!isset($this->args[$arg]) || !$this->args[$arg]){
	          $missingArgs[] = $arg;
	        }else{
	          // $clean_args[$arg] = $this->args[$arg];
	        }
	      }else{
	        // if(isset($args[$arg]))
	          // $clean_args[$arg] = $args[$arg];
	      }
	    }
	    return $missingArgs;
	}
	// private function argExist($arg, $argConf){
	// }
}
?>