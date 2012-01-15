<?php
// require_once('ingredient.class.php');
require_once('classes/Resoponse.class.php');
require_once('classes/Clean.class.php');
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
		// $ingredients = $args['ingredients'];

		$query = "INSERT INTO recipes (title, description, author, portions, category)
		VALUES('{$title}', '{$description}', '{$this->user}', '{$portions}', '{$category}')";
		$result = mysql_query($query)or die(mysql_error());
		if($result){
			$recipe = mysql_insert_id();
			$this->response->addData('recipe', $recipe);
			// for($i = 0; $i < count($ingredients); $i++){
			// 	$ingredient = new _ingredient($recipe);
			// 	$ret = $ingredient->add($ingredients[$i]);
			// 	if($ret->checkSuccess() == false){
			// 		return $ret;
			// 	}
			// }
		} else {
			$this->response->addError('Couldnt add the recipe');
		}
		return $this->response;
	}
	// public function get($args){
	// 	$recipeWithIng = $this->getRecipeWithIng($args);
	// 	if(!$recipeWithIng){
	// 		$this->response->addError('Couldnt fetch the recipe!');
	// 		return $this->response;
	// 	}
	// 	$this->response->addData('recipe', $recipeWithIng);
	// 	return $this->response;
	// }
	public function listRecipes($args){
			$select = "SELECT recipes.id, recipes.title, categories.category, categories.id AS categoryid, users.user as author ";
			$from = "FROM recipes ";
			$join = "INNER JOIN categories 
							ON categories.id=recipes.category
					INNER JOIN users
							ON users.id=recipes.author ";
			$where = " ";
			if(isset($args['category']) && $args['category']){
				$where .= "WHERE recipes.category={$args['category']} ";
			} else if(isset($args['author']) && $args['author']){
				$where .= "WHERE recipes.author={$args['author']} ";
			} else if(isset($args['myRecipes']) && $args['myRecipes'] == true){
				$where .= "WHERE recipes.author={$_SESSION['user']} ";
			}
			$query = $select .= $from .= $join .= $where;

		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$recipes = array();
			while($row = mysql_fetch_assoc($result)){
				$recipes[] = $row;
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
				$categories[] = $row;
			}
			$this->response->addData('categories', $categories);
		}
	}
	private function getAuthors(){
		$query = "SELECT id, user as author FROM users";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$authors = array();
			while($row = mysql_fetch_assoc($result)){
				$authors[] = $row;
			}
			$this->response->addData('authors', $authors);
		}
		// return $this->response;
	}
	public function getRecipeWithIng($args){
		$recipeId = $args['recipe'];
		$recipe = $this->getRecipe($args);
		$ingredients = $this->getIngredients($args);
		$recData = "";

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

		// $query = "SELECT recipes.title, recipes.description, recipes.portions, users.user as author, ingredients.ingredient, units.name AS unit, recipecontains.amount
		// 		FROM recipes, users, ingredients, units, recipecontains
		// 		WHERE ingredients.id=recipecontains.ingredient
		// 		AND units.id=recipecontains.unit
		// 		AND recipecontains.recipe={$recipe}
		// 		AND recipes.id={$recipe}
		// 		AND recipes.author=users.id";
		// $result = mysql_query($query)or die(mysql_error());
		// if($result && mysql_num_rows($result) > 0){
		// 	$recipe = "";
		// 	$row = mysql_fetch_assoc($result);
		// 	$recipe['info'] = array("title"=>$row["title"], "description"=>$row["description"], "portions"=>$row["portions"], "author" => $row['author']);
		// 	do{
		// 		$recipe['ingredients'][] = array("unit" => $row['unit'], "amount" => $row['amount'], "ingredient" => $row['ingredient']);				
		// 	}while($row = mysql_fetch_assoc($result));
		// 	return $recipe;
		// } else {
		// 	return false;
		// }
	}
		private function getRecipe($args){
		$recipe = $args['recipe'];
		$query = "SELECT recipes.id, recipes.title, recipes.description, recipes.portions, users.user as author
				  FROM recipes, users
				  WHERE recipes.id={$recipe}
				  AND recipes.author=users.id
				  LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			return $row;
		} else {
			return false;
		}
	}
	private function getIngredients($args){
		$recipe = $args['recipe'];
		$query = "SELECT ingredients.id, ingredients.ingredient, units.name AS unit, recipecontains.amount
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
			return false;
		}
	}
	// private function excecuteQuery($query){
	// 	$result = mysql_query($query) or die(mysql_error());
	// 	if($result && mysql_num_rows($result > 0)){
	// 		return $result;
	// 	} else {
	// 		return -1;
	// 	}
	// }
}
?>