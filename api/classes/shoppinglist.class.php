<?php
require_once('classes/Resoponse.class.php');
require_once('classes/Clean.class.php');
class _shoppinglist{
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
			$this->response->addError('Couldnt remove the recipe from the list!');
		}
		return $this->response;
	}
	public function get($args){
		$query = "SELECT shoppinglist.id AS listItemId, recipes.id AS recipeId, recipes.title, ingredients.ingredient, SUM(recipecontains.amount) AS amount, units.name AS unit
				  FROM shoppinglist
				  INNER JOIN recipecontains
				  	ON recipecontains.recipe=shoppinglist.recipe
				  INNER JOIN recipes
				  	ON shoppinglist.recipe=recipes.id
				  INNER JOIN ingredients
				  	ON recipecontains.ingredient=ingredients.id
				  INNER JOIN units
				  	ON recipecontains.unit=units.id
				  WHERE shoppinglist.user='{$_SESSION['user']}'
				  GROUP BY recipecontains.ingredient, recipecontains.unit";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$ret;
			while($row = mysql_fetch_assoc($result)){
				$ret[] = Clean::cleanOutput($row);
			}
			$this->response->addData('shoppinglist', $ret);
		} else {
			$this->response->addError('Couldnt fetch the shopping list');
		}
		return $this->response;
	}
}
?>