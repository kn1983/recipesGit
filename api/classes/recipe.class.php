<?php
require_once 'ingredient.class.php';
class _recipe {
	private $user;
	function __construct(){
		if(isset($_SESSION['user']) && $_SESSION['user']){
			$this->user = $_SESSION['user'];
		}
	}
	public function add($args){
			$cleanArgs = $this->cleanArgs($args);
		// $query = "INSERT INTO recipes (title, description, author, portions)
		// VALUES('{$cleanArgs['recipeTitle']}', '{$cleanArgs['recipeDescription']}', '{$this->user}', '{$cleanArgs['portions']}')";
		
		// $result = mysql_query($query)or die(mysql_error());
		// if($result){
		// 	$recipe = mysql_insert_id();
		// 	$ingArgs = array("recipe" => $recipe, "ingredients" => $args['ingredients']);
		// 	$ingredient = new _ingredient();
		// 	$ingredient->add($ingArgs);
		// }
	}
	private function cleanArgs($args){
		print_r($args);
		$clean_args = array();
		foreach ($args as $key => $value){
			if(is_array($value)){
				$ingredients = $value;
				foreach($ingredients as $key => $value){
					 $value['amount'];
					 $value['unit'];
					 $value['ingredient'];
				}
			} else {
				$clean_args[$key] = mysql_real_escape_string($value);
			}
		}
		return $clean_args;
	}
}
?>