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
	public function output(){
		if(isset($_SESSION['user']) && $_SESSION['user']){
			$loggedIn = true;
		} else {
			$loggedIn = false;
		}
		$ret = array(
			'success' => $this->success,
			'generalMessage' => $this->msg,
			'errors' => $this->errors,
			'data' => $this->data,
			'loggedIn' => $loggedIn
		);
		return json_encode($ret);
	}
}
?>