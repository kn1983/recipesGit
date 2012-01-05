<div id="header">
	<h1><a href="index.php">Recept</a></h1>
	<?php if(isset($_SESSION['user']) && $_SESSION['user']){ ?>
		<ul id="mainMenu">
			<li><a href="recipes.php">Visa recept</a></li>
			<li><a href="index.php?page=searchRecipes">Sök recept</a></li>
			<li><a href="myRecipes.php">Mina recept</a></li>
			<li><a href="addRecipe.php">Lägg till recept</a></li>
			<li><a href="#">Inköpslista</a></li>
			<li><a href="#">Mitt skafferi</a></li>
			<li><a href="#" id="logout">Logga ut</a></li>
		</ul>
	<?php } else { ?>
	<ul id="mainMenu">
		<li><a href="index.php">Hem</a></li>
		<li><a href="signup.php">Registrera dig</a></li>
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