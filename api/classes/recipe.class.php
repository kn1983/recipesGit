<?php
class _recipe {
	private $user;
	function __construct(){
		if(isset($_SESSION['user']) && $_SESSION['user']){
			$this->user = $_SESSION['user'];
		}
	}
	public function add($args){
		$cleanArgs = $this->cleanArgs($args);
		$query = "INSERT INTO recipes (title, description, author, portions)
		VALUES('{$cleanArgs['recipeTitle']}', '{$cleanArgs['recipeDescription']}', '{$this->user}', '{$cleanArgs['portions']}')";
		
		$result = mysql_query($query)or die(mysql_error());
		if($result){
			$id = mysql_insert_id();
			return array("id" => $id);
		}
	}
	private function cleanArgs($args){
		$clean_args = array();
		foreach ($args as $key => $value){
			$clean_args[$key] = mysql_real_escape_string($value);
		}
		return $clean_args;
	}
}
?>