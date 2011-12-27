<?php
require_once("classes/Resoponse.class.php");
require_once("classes/Clean.class.php");
class _ingredient{
	private $response;
	function __construct($recipe){
		$this->response = new Response();
		$this->recipe = Clean::cleanArg($recipe);
	}
	public function add($args){
		// $this->validateIngredients($args);
		$ingredient = $this->ingredientExist($args);
		if($ingredient == -1){
			$ingredient =  $this->insertIngredient($args);
		}
		$this->addIngToRecipe($args, $ingredient);
		return $this->response;
		
	}
	// private function validateIngredients($args){
	// 	if($args['ingredient']
	// 	$args['amount'];
	// 	$args['unit'];
	// }
	private function addIngToRecipe($args, $ingredient){
		$ing = Clean::cleanArg($ingredient);
		$amount = Clean::cleanArg($args['amount']);
		$unit = Clean::cleanArg($args['unit']);

		$query = "INSERT INTO recipecontains (recipe, ingredient, unit, amount)
		VALUES ({$this->recipe}, {$ing}, {$unit}, {$amount})";
		$result = mysql_query($query) or die(mysql_error());
		
	}
	private function ingredientExist($args){
		$ingredient = Clean::cleanArg($args['ingredient']);
		$query = "SELECT id, ingredient FROM ingredients
		 	    WHERE ingredient='{$ingredient}'
		 	    LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());

		if($result && mysql_num_rows($result)>0){
			$row = mysql_fetch_assoc($result);
			return $row['id'];
		} else {
			return -1;
		}
	}
	private function insertIngredient($args){
		$ingredient = Clean::cleanArg($args['ingredient']);
		$query = "INSERT INTO ingredients (ingredient)
		VALUES ('{$ingredient}')";
		$result = mysql_query($query) or die(mysql_error());
		if($result){
			return mysql_insert_id();
		}
	}
}
?>