<?php
require_once("ingredient.class.php");
require_once("classes/Resoponse.class.php");
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
		$title = $this->cleanArg($args['recipeTitle']);
		$description = $this->cleanArg($args['recipeDescription']);
		$portions = $this->cleanArg($args['portions']);

		$query = "INSERT INTO recipes (title, description, author, portions)
		VALUES('{$title}', '{$description}', '{$this->user}', '{$portions}')";
		
		$result = mysql_query($query)or die(mysql_error());
		if($result){
			$recipe = mysql_insert_id();
			$ingredients = $args['ingredients'];
			for($i = 0; $i < count($ingredients); $i++){
				$ingredient = new _ingredient($recipe);
				$ret = $ingredient->add($ingredients[$i]);
				// if(!$ret->checkSuccess){
				return $this->response;
				// }

			}
			return $this->response;
		} else {
			$this->response->addError('Couldnt add the recipe');
		}
		return $this->response;
	}

	private function cleanArg($arg){
		$arg = strip_tags($arg);
		$arg = mysql_real_escape_string($arg);
		return $arg;
	}
}
?>