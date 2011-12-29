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
		$title = $args['recipeTitle'];
		$description = $args['recipeDescription'];
		$portions = $args['portions'];
		$ingredients = $args['ingredients'];

		$title = Clean::cleanArg($title);
		$description = Clean::cleanArg($description);
		$portions = Clean::cleanArg($portions);

		$query = "INSERT INTO recipes (title, description, author, portions)
		VALUES('{$title}', '{$description}', '{$this->user}', '{$portions}')";
		$result = mysql_query($query)or die(mysql_error());
		if($result){
			$recipe = mysql_insert_id();
			for($i = 0; $i < count($ingredients); $i++){
				$ingredient = new _ingredient($recipe);
				$ret = $ingredient->add($ingredients[$i]);
				// if(!$ret->checkSuccess){
				return $ret;
				// }

			}
			return $this->response;
		} else {
			$this->response->addError('Couldnt add the recipe');
		}
		return $this->response;
	}
	public function listRecipes($args){
		$query = "SELECT recipes.id, recipes.title, users.user 
				  FROM recipes, users
				  WHERE users.id=recipes.author
				  GROUP BY recipes.title";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			while($row = mysql_fetch_assoc($result)){
				// $ret[] = $row;
				$this->response->addData($row);
			}
		}
		return $this->response;
	}
}
?>