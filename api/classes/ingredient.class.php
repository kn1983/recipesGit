<?php
require_once('classes/Resoponse.class.php');
require_once('classes/Validate.class.php');
require_once('classes/Clean.class.php');
class _ingredient{
	private $response;
	private $validate;
	function __construct(){
		$this->response = new Response();
		$this->validate = new Validate();
	}
	public function remove($args){
		$ingredient = Clean::cleanArg($args['ingredient']);
		$recipe = Clean::cleanArg($args['recipe']);
	
		$query = "DELETE FROM recipecontains
				  WHERE recipe={$recipe}
				  AND ingredient={$ingredient}";
		mysql_query($query)or die(mysql_error());
		return $this->response;
	}
	public function add($args){
		$ingredient = $this->ingredientExist($args['ingredient']);
		if(!$ingredient){
			$ingredient =  $this->insertIngredient($args['ingredient']);
		}
		$this->addIngToRecipe($args, $ingredient);
		return $this->response;
		
	}
	public function update($args){
		if($this->ingredientExistInRecipe($args)){
			$this->response->setGeneralMsg('The ingredient is already up to date!');
			return $this->response;
		} else {
			return $this->response;
		}
		// $ingredient = $this->ingredientExist($args['ingredient']);
		// if(!$ingredient){
		// 	$ingredient =  $this->insertIngredient($args['ingredient']);
		// }
		// $this->addIngToRecipe($args, $ingredient);
		// return $this->response;
	}
	private function addIngToRecipe($args, $ingredient){
		$recipe = Clean::cleanArg($args['recipe']);
		$ing = Clean::cleanArg($ingredient);
		$amount = Clean::cleanArg($args['amount']);
		$unit = Clean::cleanArg($args['unit']);

		$query = "INSERT INTO recipecontains (recipe, ingredient, unit, amount)
		VALUES ({$recipe}, {$ing}, {$unit}, {$amount})";
		$result = mysql_query($query) or die(mysql_error());
		
	}
	private function ingredientExistInRecipe($args){
		$ingId = Clean::cleanArg($args['ingredientId']);
		$ingredient = Clean::cleanArg($args['ingredient']);
		$recipe = Clean::cleanArg($args['recipe']);

		$query = "SELECT ingredients.ingredient 
				  FROM recipecontains, ingredients
				  WHERE recipecontains.ingredient='{$ingId}'
				  AND recipecontains.recipe='{$recipe}'
				  AND ingredients.ingredient='{$ingredient}'
				  LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result)>0){
			return true;
		} else {
			return false;
		}
	}
	private function ingredientExist($ing){
		$ingredient = Clean::cleanArg($ing);
		$query = "SELECT id, ingredient FROM ingredients
		 	      WHERE ingredient='{$ingredient}'
		 	   	  LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());

		if($result && mysql_num_rows($result)>0){
			$row = mysql_fetch_assoc($result);
			return $row['id'];
		} else {
			return false;
		}
	}
	private function insertIngredient($ing){
		$ingredient = Clean::cleanArg($ing);
		$query = "INSERT INTO ingredients (ingredient)
		VALUES ('{$ingredient}')";
		$result = mysql_query($query) or die(mysql_error());
		if($result){
			return mysql_insert_id();
		}
	}
}
?>