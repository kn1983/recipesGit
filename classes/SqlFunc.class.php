<?php
class SqlFunc{
	function __construct(){
		
	}
	public function listRecipes(){
		$query = "SELECT recipes.id, recipes.title, users.user
				  FROM recipes, users
				  WHERE users.id=recipes.author";
		$result = mysql_query($query) or die(mysql_error());
		return $result;
	}
	public function getRecipe(){
		if(isset($_GET['id']) && $_GET['id']){
			$id = $_GET['id'];
			$query = "SELECT id, title, description, author, portions
					  FROM recipes
				      WHERE id={$id}
				      LIMIT 1";
			$result = mysql_query($query) or die(mysql_error());
			return $result;
		}
	}
	public function getIngredients($recipe){
		$query = "SELECT ingredients.ingredient, recipecontains.amount, units.name as unit
				  FROM ingredients, recipecontains, units
				  WHERE recipecontains.ingredient = ingredients.id
				  AND recipecontains.unit = units.id
				  AND recipecontains.recipe = {$recipe}";
		$result = mysql_query($query) or die(mysql_error());
		return $result;
	}
	public function listCategories(){
		$query = "SELECT id, category
				  FROM categories";
		$result = mysql_query($query) or die(mysql_error());
		return $result;
	}
}
?>