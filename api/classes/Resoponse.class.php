<?php
class Response{
	private $errors = array();
	private $data = array();
	private $msg;
	private $success = true;

	function __construct(){
	}

	public function addError($errors){
		$this->errors[] = $errors;
		$this->success = false;
	}

	public function addData($type, $data){
		$this->data[$type] = $data;
	}
	public function setGeneralMsg($msg){
		$this->msg = $msg;
	}
	public function checkSuccess(){
		if($this->success == true){
			return true;
		} else {
			return false;
		}
	}

	// public static function success(){
	// 	$ret = array(
	// 		'success' => true,
	// 		'generalMessage' => "",
	// 		'errors' => "",
	// 		'data' => ""
	// 	); 
	// 	return json_encode($ret);
	// }
	
	public static function error(){
		$ret = array(
			'success' => false,
			'generalMessage' => "",
			'errors' => "",
			'data' => ""
		); 
		return json_encode($ret);
	}	

	public function output(){
		$ret = array(
			'success' => $this->success,
			'generalMessage' => $this->msg,
			'errors' => $this->errors,
			'data' => $this->data
		);
		return json_encode($ret);
	}
}
?>