<?php
require_once('classes/Resoponse.class.php');
require_once('classes/Validate.class.php');
require_once('classes/Clean.class.php');
class Ingredient{
	private $response;
	private $validate;
	function __construct(){
		$this->response = new Response();
		$this->validate = new Validate();
	}
	public function remove($args){
		$this->removeIngFromRecipe($args);
		return $this->response;
	}
	public function add($args){
		$ingredient = $this->ingredientExist($args['ingredient']);
		if(!$ingredient){
			$ingredient = $this->insertIngredient($args['ingredient']);
		}
		$this->addIngToRecipe($args, $ingredient);
		return $this->response;
		
	}
	public function update($args){
		$unit = Clean::cleanArg($args['unit']);
		$amount = Clean::cleanArg($args['amount']);
		$recConId = Clean::cleanArg($args['recConId']);
		$ingredient = $this->ingredientExist($args['ingredient']);
		if(!$ingredient){
			$ingredient = $this->insertIngredient($args['ingredient']);
		}
		$query = "UPDATE recipecontains
				  SET ingredient='{$ingredient}', amount='{$amount}', unit='{$unit}'
				  WHERE id='{$recConId}'";
		$result = mysql_query($query) or die(mysql_error());
		if(!$result){
			$this->response->addError('Couldnt update the ingredient');
		}
		return $this->response;
	}
	private function addIngToRecipe($args, $ingredient){
		$recipe = Clean::cleanArg($args['recipe']);
		$ing = Clean::cleanArg($ingredient);
		$amount = Clean::cleanArg($args['amount']);
		$unit = Clean::cleanArg($args['unit']);

		$query = "INSERT INTO recipecontains (recipe, ingredient, unit, amount)
		VALUES ('{$recipe}', '{$ing}', '{$unit}', '{$amount}')";
		$result = mysql_query($query);
		if(!$result){
			$this->response->addError('Couldnt add the ingredient!');
		}
		
	}
	private function removeIngFromRecipe($args){
		$id = Clean::cleanArg($args['recConId']);
		$recipe = Clean::cleanArg($args['recipe']);
	
		$query = "DELETE FROM recipecontains
				  WHERE recipe={$recipe}
				  AND id={$id}";
		$result = mysql_query($query)or die(mysql_error());
		if(!$result){
			$this->addError('Couldnt remove the ingredient!');
		}
	}
	private function ingredientExist($ing){
		$ingredient = Clean::cleanArg($ing);
		$query = "SELECT id, ingredient FROM ingredients
		 	      WHERE ingredient='{$ingredient}'
		 	   	  LIMIT 1";
		$cleanResult = Clean::executeQueryAndCleanResult($query, true);
		if($cleanResult){
			return $cleanResult['id'];
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