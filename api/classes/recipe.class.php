<?php
require_once("ingredient.class.php");
require_once("classes/Resoponse.class.php");
require_once("classes/Clean.class.php");
class _recipe {
	private $user;
	private $response;
	function __construct(){
		$this->response = new Response();
		if(isset($_SESSION['user']) && $_SESSION['user']){
			$this->user = $_SESSION['user'];
		}
	}
	public function add($args){
		$title = Clean::cleanArg($args['recipeTitle']);
		$description = Clean::cleanArg($args['recipeDescription']);
		$portions = Clean::cleanArg($args['portions']);
		$category = Clean::cleanArg($args['category']);
		$ingredients = $args['ingredients'];

		$query = "INSERT INTO recipes (title, description, author, portions, category)
		VALUES('{$title}', '{$description}', '{$this->user}', '{$portions}', '{$category}')";
		$result = mysql_query($query)or die(mysql_error());
		if($result){
			$recipe = mysql_insert_id();
			for($i = 0; $i < count($ingredients); $i++){
				$ingredient = new _ingredient($recipe);
				$ret = $ingredient->add($ingredients[$i]);
				if($ret->checkSuccess() == false){
					return $ret;
				}
			}
		} else {
			$this->response->addError('Couldnt add the recipe');
		}
		return $this->response;
	}
	public function listRecipes($args){
			$select = "SELECT recipes.id, recipes.title, users.user, recipes.category ";
			$from = "FROM recipes, users, categories ";
			$where = "WHERE users.id=recipes.author ";
			if(isset($args['category']) && $args['category']){
				$where .= "AND recipes.category={$args['category']} ";
			}
			$group = "GROUP BY recipes.title ";

			$query = $select .= $from .= $where .= $group;

		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$recipes = array();
			while($row = mysql_fetch_assoc($result)){
				$recipes[] = $row;
			}
			$this->response->addData('recipes', $recipes);
		} else {
			$this->response->addError("No reipes on this category!");
		}
		return $this->response;
	}
	public function listCategories($args){
		$query = "SELECT id, category FROM categories";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$categories = array();
			while($row = mysql_fetch_assoc($result)){
				$categories[] = $row;
			}
			$this->response->addData('categories', $categories);
		}
		return $this->response;
	}
	public function display($args){
		$recipe = $this->getRecipe($args);
		$ingredients = $this->getIngredients($args);

		if($recipe == -1){
			$this->response->addError('Couldnt fetch the recipe!');
		} else if($ingredients == -1){
			$this->response->addError('Couldnt feth the ingredients!');
		} else {
			$this->response->addData('ingredients', $ingredients);
			$this->response->addData('recipe', $recipe);
			// $this->response->addData('recipe', $data);
		}
		return $this->response;
	}
	private function getRecipe($args){
		$recipe = $args['recipe'];
		$query = "SELECT recipes.title, recipes.description, recipes.portions, users.user as author
				  FROM recipes, users
				  WHERE recipes.id={$recipe}
				  AND recipes.author=users.id
				  LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			return $row;
		} else {
			return -1;
		}
	}
	private function getIngredients($args){
		$recipe = $args['recipe'];
		$query = "SELECT ingredients.ingredient, units.name AS unit, recipecontains.amount
				  FROM ingredients, units, recipecontains
				  WHERE ingredients.id=recipecontains.ingredient
				  AND units.id=recipecontains.unit
				  AND recipecontains.recipe={$recipe}";
		$result = mysql_query($query)or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$ingredients = array();
			while($row = mysql_fetch_assoc($result)){
				$ingredients[] = $row;
			}
			return $ingredients;
		} else {
			return -1;
		}
	}
}
?>