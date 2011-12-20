<?php
class _recipe {
	private $user;
	function __construct(){
		if(isset($_SESSION['user']) && $_SESSION['user']){
			$this->user = $_SESSION['user'];
		}
	}
	public function add($args){
		$query = "INSERT INTO recipes (title, description, author, portions)
		VALUES('{$args['recipeTitle']}', '{$args['recipeDescription']}', '{$this->user}', '{$args['portions']}')";
		
		$result = mysql_query($query)or die(mysql_error());
		if($result){
			$id = mysql_insert_id();
			return array("id" => $id);
		}
	}
}
?>