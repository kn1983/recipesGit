<?php
require_once("classes/Resoponse.class.php");
class _user {
	private $response;
	function __construct(){
		$this->response = new Response();
	}
	
	//Login user
	public function login($args){
		if($this->validLogin($args)){
			return $this->response;
		} else {
			$this->response->addError("Invalid login");
			$this->response->setGeneralMsg("Wrong username or password!");
			return $this->response;
		}
	}
	
	//Check username and password for the login form
	private function validLogin($args){
		$user = $args['user'];
		$password = md5($args['password']);
		$query = "SELECT id, user, password 
				  FROM users
				  WHERE user='{$args['user']}'";
		$result = mysql_query($query)or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		
		if($row['user'] == $user && $row['password'] == $password){
			$_SESSION['user'] = $row['id'];
			return true;
		} else {
			return false;
		}
	}
	
	//Logout user
	public function logout($args){
		session_destroy();
	}
	
	//Signup user
	public function signup($args){
		if($this->userExist($args) && $this->validateEmail($args)){
			$this->addUser($args);
			return array("success" => true, "msg" => "");
		} else {
			return array("success" => false, "msg" => "Användarnamnet är redan upptaget");
		}
	}
	//Check if user exist in the table users
	private function userExist($args){
		$user = $args['regUser'];
		$query = "SELECT user FROM users
		          WHERE user='{$user}'";
		
		$result = mysql_query($query)or die(mysql_error());
		if($result && mysql_num_rows($result)>0){
			return false;
		} else {
			return true;
		}
	}
	
	//Validate email
	private function validateEmail($args){
		return preg_match('/^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/', $args['regEmail']);
	}
	
	//Add the the user to the table users
	private function addUser($args){
		$user = $args['regUser'];
		$password = md5($args['regPassword']);
		$email = $args['regEmail'];
		$query = "INSERT INTO users (user, password, email)
		 		  VALUES('{$user}', '{$password}', '{$email}')";
		$result = mysql_query($query)or die(mysql_error());
	}
}
?>