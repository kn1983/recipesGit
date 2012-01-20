<?php
require_once('classes/Resoponse.class.php');
require_once('classes/Validate.class.php');
require_once('classes/Clean.class.php');
class _user {
	private $response;
	private $validate;
	function __construct(){
		$this->response = new Response();
		$this->validate = new Validate();
	}
	public function checkLogin($args){
		if(isset($_SESSION['user']) && $_SESSION['user']){
			$this->response->addData('login', true);
		} else {
			$this->response->addData('login', false);
		}
		return $this->response;
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
		$user = Clean::cleanArg($args['user']);
		$password = md5(Clean::cleanArg($args['password']));
		$query = "SELECT id, user, password 
				  FROM users
				  WHERE user='{$user}'";
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
		return $this->response;
	}
	
	//Signup user
	public function signup($args){
		if(!$this->validate->email($args['regEmail'])){
			$this->response->addError('Invalid E-mail address!');
		}
		if(!$this->userExist($args)){
			$this->response->addError('The username is already taken!');
		}
		if(!$this->response->checkSuccess()){
			return $this->response;	
		}else{
			$this->addUser($args);
			return $this->response;	
		}
	}

	//Check if user exist in the table users
	private function userExist($args){
		$user = Clean::cleanArg($args['regUser']);
		$query = "SELECT user FROM users
		          WHERE user='{$user}'";
		
		$result = mysql_query($query)or die(mysql_error());
		if($result && mysql_num_rows($result)>0){
			return false;
		} else {
			return true;
		}
	}
	
	//Add the the user to the table users
	private function addUser($args){
		$user = Clean::cleanArg($args['regUser']);
		$password = md5(Clean::cleanArg($args['regPassword']));
		$email = Clean::cleanArg($args['regEmail']);
		$query = "INSERT INTO users (user, password, email)
		 		  VALUES('{$user}', '{$password}', '{$email}')";
		$result = mysql_query($query)or die(mysql_error());
		if(!$result){
			$this->response->addError("Could not add user!");
		}
	}
}
?>