<?php
require_once('classes/Resoponse.class.php');
require_once('classes/Clean.class.php');
class _search{
	private $response;
	function __construct(){
		$this->response = new Response();
	}
	public function searchAll($args){
		$searchStr = $args['searchStr'];
		$searchStr = Clean::cleanArg($args['searchStr']);
		$searchArray = explode(',', $searchStr);
		$select = "SELECT recipes.id, recipes.title, recipes.description, categories.category
		FROM recipes
		LEFT JOIN recipecontains
			ON recipes.id=recipecontains.recipe
		INNER JOIN categories
			ON categories.id=recipes.category
		LEFT JOIN ingredients
			ON recipecontains.ingredient=ingredients.id";
		$where = "";
		$and = "";
		$groupBy = "GROUP BY recipes.id ";
		$categoryArray = "";
		$strs = "";
		for($i = 0; $i < count($searchArray); $i++){
			$str = trim($searchArray[$i]);
			$strs[] = $str; 
			if($str != ""){
				$category = $this->checkIfCategory($str);
				$categoryArray[] = $category;
				if($str == $category){
					if($and == ""){
						$and .= "categories.category='{$category}' ";
					} else {
						$and .= "AND categories.category='{$category}' ";	
					}
				} else {
					$str = '%'. $str .'%';
					if($where == ""){
						$where .= "recipes.title LIKE '{$str}' ";
					} else {
						$where .= "OR recipes.title LIKE '{$str}' ";
					}
					$where .= "OR ingredients.ingredient LIKE '{$str}' ";
			 		$where .= "OR recipes.description LIKE '{$str}' ";
				}
			}
    	}
    	if($where == ""){
    		$query = "{$select} WHERE {$and}{$groupBy}";	
    	} 
    	else if($and == ""){
    		$query = "{$select} WHERE({$where}){$groupBy}";	
    	} else {
    		$query = "{$select} WHERE({$where}) AND {$and}{$groupBy}";
    	}
	    // $this->response->addData('where', $where);
	    // $this->response->addData('and', $and);
	    $this->response->addData('categories', $categoryArray);
	    $this->response->addData('strs', $strs);
	    $this->response->addData('query', utf8_encode($query));

	    $result = mysql_query($query) or die(mysql_error());
	    if($result && mysql_num_rows($result) > 0){
	    	$searchResult = "";
	    	while($row = mysql_fetch_assoc($result)){
	    		$searchResult[] = Clean::utf8Encode($row);
	    	}
	    	$this->response->addData('searchResult', $searchResult);
	    } else {
	    	$this->response->addError('No hits');
	    }
	    return $this->response;
	}

	private function checkIfCategory($str){
		// $category = Clean::cleanArg($str);
		$query = "SELECT id, category FROM categories
				  WHERE category='{$str}'
				  LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());
		if($result && mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			return $row['category'];
		} else {
			return false;
		}
	}
}

// SELECT recipes.id, recipes.title, recipes.description, categories.category
// 		FROM recipes
// 		LEFT JOIN recipecontains
// 			ON recipes.id=recipecontains.recipe
// 		INNER JOIN categories
// 			ON categories.id=recipes.category
// 		LEFT JOIN ingredients
// 			ON recipecontains.ingredient=ingredients.id
//                 WHERE recipes.title LIKE '%banan%'
//                 OR recipes.description LIKE '%banan%'
//                 OR ingredients.ingredient LIKE '%banan%'
//                 AND categories.category='efterrätter'





//         SELECT recipes.id, recipes.title, recipes.description, categories.category
// 		FROM recipes
// 		LEFT JOIN recipecontains
// 			ON recipes.id=recipecontains.recipe
// 		INNER JOIN categories
// 			ON categories.id=recipes.category
// 		LEFT JOIN ingredients
// 			ON recipecontains.ingredient=ingredients.id
//                 WHERE categories.category='Efterrätter'
//                 AND recipes.description LIKE '%banan%'
//                 OR ingredients.ingredient LIKE '%banan%'
//                 or recipes.title LIKE '%banan%'









?>