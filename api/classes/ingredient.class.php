<?php
class _ingredient{
	function __construct(){
		
	}
	private function add($args){
		$clean_args = $this->cleanArgs($args);
		$id = ingredientExist($args);
		if($id == -1){
			$id = insertIngredient($args);
		}
		$this->addIngToRecipe($args); 
	}
	private function ingredientExist($args){
		// return mysql_insert_id();
	}
	private function insertIngredient($args){
		// $query = "INSERT INTO ingredients (ingredient)
		// VALUES ()";
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