<?php
// require_once('ingredient.class.php');
require_once('classes/Resoponse.class.php');
require_once('classes/Clean.class.php');
require_once('classes/units.class.php');
class Recipe {
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

		$query = "INSERT INTO recipes (title, description, author, portions, category)
		VALUES('{$title}', '{$description}', '{$this->user}', '{$portions}', '{$category}')";
		$result = mysql_query($query)or die(mysql_error());
		if($result){
			$recipe = mysql_insert_id();
			$this->response->addData('recipe', $recipe);
		} else {
			$this->response->addError('Couldnt add the recipe');
		}
		return $this->response;
	}
	public function edit($args){
		if($this->user){
			$recipe = Clean::cleanArg($args['recipe']);
			$title = Clean::cleanArg($args['recipeTitle']);
			$description = Clean::cleanArg($args['recipeDescription']);
			$portions = Clean::cleanArg($args['portions']);
			$category = Clean::cleanArg($args['category']);
			$query = "UPDATE recipes
					  SET title='{$title}', description='{$description}', portions='{$portions}', category='{$category}'
					  WHERE id={$recipe}";
			if(!mysql_query($query)){
				$this->response->addError('Couldnt edit the recipe!');
			}
		} else {
			$this->response->addError('Login is required!');
		}
		return $this->response;
	}
	public function listRecipes($args){
			$select = "SELECT recipes.id, recipes.title, categories.category, categories.id AS categoryid, users.user as author ";
			$from = "FROM recipes ";
			$join = "INNER JOIN categories 
							ON categories.id=recipes.category
					INNER JOIN users
							ON users.id=recipes.author ";
			$where = " ";
			$orderBy = "ORDER BY recipes.title ASC ";
			if(isset($args['category']) && $args['category']){
				$where .= "WHERE recipes.category={$args['category']} ";
			} else if(isset($args['author']) && $args['author']){
				$where .= "WHERE recipes.author={$args['author']} ";
			} else if(isset($args['myRecipes']) && $args['myRecipes'] == true){
				$where .= "WHERE recipes.author={$_SESSION['user']} ";
			}
			$query = $select .= $from .= $join .= $where .= $orderBy;

		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$recipes = array();
			while($row = mysql_fetch_assoc($result)){
				$recipes[] = Clean::cleanOutput($row);
			}
			$this->response->addData('recipes', $recipes);
		} else {
			$this->response->addError("Couldn't fetch the recipes!");
		}
		return $this->response;
	}
	public function getAllCategories($args){
		$this->getCategories();
		return $this->response;
	}
	public function getCatsAndAuthors($args){
		$this->getCategories();
		$this->getAuthors();
		return $this->response;
	}
	private function getCategories(){
		$query = "SELECT id, category FROM categories";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$categories = array();
			while($row = mysql_fetch_assoc($result)){
				$categories[] = Clean::cleanOutput($row);
			}
			$this->response->addData('categories', $categories);
		} else {
			$this->response->addError('Couldnt fetch the categories!');
		}
	}
	private function getAuthors(){
		$query = "SELECT id, user as author FROM users";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$authors = array();
			while($row = mysql_fetch_assoc($result)){
				$authors[] = Clean::cleanOutput($row);
			}
			$this->response->addData('authors', $authors);
		}
	}
	public function getRecipeIngUnitsAndCats($args){
		$this->getCategories();
		$recipe = $this->getRecipe($args);
		$ingredients = $this->getIngredients($args);
		$unitsClass = new Units();
		$units = $unitsClass->getUnits($args);
		$recData = "";
		if($units){
			$this->response->addData('units', $units);
		} else {
			$this->response->addError('Couldnt fetch the units!');
		}
		if($recipe){
			$recData['info'] = $recipe;
		} else {
			$this->response->addError('Couldnt fetch the recipe!');
			return $this->response;
		}
		if($ingredients){
			$recData['ingredients'] = $ingredients;
		}
		$this->response->addData('recipe', $recData);
		return $this->response;
	}
	private function getRecipe($args){
		$recipe = $args['recipe'];
		$query = "SELECT recipes.id, recipes.title, recipes.description, recipes.portions, categories.id AS categoryId, categories.category, users.user as author
				  FROM recipes, users, categories
				  WHERE recipes.id={$recipe}
				  AND recipes.author=users.id
				  AND recipes.category=categories.id
				  LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			return Clean::cleanOutput($row);
		} else {
			return false;
		}
	}
	private function getIngredients($args){
		$recipe = $args['recipe'];
		$query = "SELECT recipecontains.id as recConId, ingredients.id as ingId, ingredients.ingredient, units.id as unitId, units.name AS unit, recipecontains.amount
				  FROM ingredients, units, recipecontains
				  WHERE ingredients.id=recipecontains.ingredient
				  AND units.id=recipecontains.unit
				  AND recipecontains.recipe={$recipe}";
		$result = mysql_query($query)or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$ingredients = array();
			while($row = mysql_fetch_assoc($result)){
				$ingredients[] = Clean::cleanOutput($row);
			}
			return $ingredients;
		} else {
			return false;
		}
	}
}
?>