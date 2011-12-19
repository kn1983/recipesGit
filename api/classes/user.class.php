<?php
class _user {
	function __construct(){
	}
	
	//Login user
	public function login($args){
		if($this->validLogin($args)){
			return array("success" => true, "msg" => "");
		} else {
			return array("false" => false, "msg" => "Fel användarnamn eller lösenord");
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
			// $_SESSION['user'] = $user;
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