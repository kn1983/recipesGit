<?php
class DbLogin{
	
	public function __construct(){
		$this->login();
	}
	private function login(){
		mysql_connect('localhost', 'root', 'root')or die(mysql_error());
		mysql_select_db('s0020...recProj')or die(mysql_error());
	}
}
?>