<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Recept</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="css/style.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="js/jquery-1.6.4.js"></script>
		<script type="text/javascript" src="js/jquery.hashchange-1.0.0.js"></script>
		<script type="text/javascript" src="js/printPage.js"></script>
		<script type="text/javascript" src="js/userFunc.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h1><a href="#">Recept</a></h1>
				<?php if(isset($_SESSION['user']) && $_SESSION['user']){ ?>
					<ul id="mainMenu">
						<li><a href="#search">Sök recept</a></li>
						<li><a href="#myRecipes">Mina recept</a></li>
						<li><a href="#addRecipe">Lägg till recept</a></li>
						<li><a href="#shoppinglist">Inköpslista</a></li>
						<li><a href="#">Mitt skafferi</a></li>
						<li><a href="#" id="logout">Logga ut</a></li>
					</ul>
				<?php } else { ?>
				<ul id="mainMenu">
					<li><a href="#">Hem</a></li>
					<li><a href="#signup">Registrera dig</a></li>
				</ul>
				<form id="loginForm" method="post" action="index.php">
					<label for="user">Användarnamn</label>
					<input type="text" id="user" name="user" />
					<label for="password">Lösenord</label>
					<input type="password" id="password" name="password" />
					<button type="submit" id="login" name="login">Logga in</button>
				</form>
				<? } ?>
			</div>
			<div id="sidebar"></div>
			<div id="content"></div>
		</div>
	</body>
</html>