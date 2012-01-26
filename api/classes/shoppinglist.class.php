<?php
require_once('classes/Resoponse.class.php');
require_once('classes/Clean.class.php');
class Shoppinglist{
	private $response;
	function __construct(){
		$this->response = new Response();
	}
	public function add($args){
		$recipe = Clean::cleanArg($args['recipe']);
		$query = "INSERT INTO shoppinglist (user, recipe)
				  VALUES ('{$_SESSION['user']}', '{$recipe}')";
		$result = mysql_query($query);
		if(!$result){
			$this->response->addError('Receptet ligger redan i inköpslistan!');
		}
		return $this->response;
	}
	public function remove($args){
		$listItem = Clean::cleanArg($args['itemId']);
		$query = "DELETE FROM shoppinglist
				  WHERE id='{$listItem}'";
		$result = mysql_query($query);
		if(!$result){
			$this->response->addError('Kunde inte ta bort receptet från inköpslistan!');
		}
		return $this->response;
	}
	public function get($args){
		$recipes = $this->getRecipes();
		$listItems = $this->getListItems();

		if($recipes && $listItems){
			$this->response->addData('recipes', $recipes);
			$this->response->addData('listItems', $listItems);
		} else {
			$this->response->addError('Din inköpslista är tom!');
		}
		return $this->response;
	}
	private function getListItems(){
		$query = "SELECT ingredients.ingredient, SUM(recipecontains.amount) AS amount, units.name AS unit
				  FROM shoppinglist
				  INNER JOIN recipecontains
				  	ON recipecontains.recipe=shoppinglist.recipe
				  INNER JOIN ingredients
				  	ON recipecontains.ingredient=ingredients.id
				  INNER JOIN units
				  	ON recipecontains.unit=units.id
				  WHERE shoppinglist.user='{$_SESSION['user']}'
				  GROUP BY recipecontains.ingredient, recipecontains.unit";
		$cleanResult = Clean::executeQueryAndCleanResult($query, false);
		if($cleanResult){
			return $cleanResult;
		} else {
			return false;
		}	  
	}
	private function getRecipes(){
		$query = "SELECT shoppinglist.id AS listItemId, recipes.id AS recipeId, recipes.title
				  FROM shoppinglist
				  INNER JOIN recipes
					ON shoppinglist.recipe=recipes.id
				  WHERE shoppinglist.user='{$_SESSION['user']}'";
		$cleanResult = Clean::executeQueryAndCleanResult($query, false);
		if($cleanResult){
			return $cleanResult;
		} else {
			return false;
		}	  
	}
}
?>