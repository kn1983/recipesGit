<?php
class _ingredient{
	function __construct(){
		
	}
	private function add($args){
		$clean_arg = $this->cleanArgs($args);
		print_r($clean_arg);
		// $id = ingredientExist($args);
		// if($id == -1){
		// 	$id = insertIngredient($args);
		// }
		// $this->addIngToRecipe($args); 
	}
	private function ingredientExist($args){
		// $query = "SELECT ingredient FROM ingredients
		// 		  WHERE ingredient='{$args['ingredients']['ingredient']}'
		// 		  LIMIT 1";
		// $result = mysql_query($query) or die(mysql_error());
		// if($result > 0){
		// 	$row = mysql_fetch_assoc($result);
		// 	return $row['id'];
		// } else {
		// 	return -1;
		// }
	}
	private function insertIngredient($args){
		// $query = "INSERT INTO ingredients (ingredient)
		// // VALUES ()";
		// return mysql_insert_id();
	}
	private function addIngToRecipe($args){
		
	}
	private function clean_args($args){
		$clean_args = array();
		foreach ($args as $key => $value){
			$clean_args[$key] = mysql_real_escape_string($value);
		}
		return $clean_args;
	}
}
?>