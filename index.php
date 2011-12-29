<?php
function __autoload($class_name){
	require_once 'classes/'. $class_name. '.class.php';
}
require_once "includes/pagesConf.php";
session_start();
$dbLogin = new DbLogin();
if(isset($_GET['page'])){
	$curPage = $_GET['page'];
} else {
	$curPage = "";
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script type="text/javascript" src="js/jquery-1.6.4.js"></script>
		<script type="text/javascript" src="js/userFunc.js"></script>
		<script type="text/javascript" src="js/recipeFunc.js"></script>
		<script type="text/javascript" src="js/displayRecipesFunc.js"></script>
		<link href="css/style.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h1><a href="index.php">Recept</a></h1>
				<?php if(isset($_SESSION['user']) && $_SESSION['user']){ ?>
					<ul id="mainMenu">
						<li><a href="index.php?page=recipes">Visa recept</a></li>
						<li><a href="index.php?page=searchRecipes">Sök recept</a></li>
						<li><a href="#">Mina recept</a></li>
						<li><a href="index.php?page=addRecipe">Lägg till recept</a></li>
						<li><a href="#">Inköpslista</a></li>
						<li><a href="#">Mitt skafferi</a></li>
						<li><a href="#" id="logout">Logga ut</a></li>
					</ul>
				<?php } else { ?>
				<ul id="mainMenu">
					<li><a href="index.php">Hem</a></li>
					<li><a href="?page=signup">Registrera dig</a></li>
				</ul>
				<form id="loginForm">
					<label for="user">Användarnamn</label>
					<input type="text" id="user" name="user" />
					
					<label for="password">Lösenord</label>
					<input type="password" id="password" name="password" />
					<button type="submit" id="login" name="login">Logga in</button>
				</form>
				<? } ?>
			</div>
			<?php $page = new Page($curPage, $_PAGES); ?>
		</div>
	</body>
</html>