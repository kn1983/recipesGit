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
		<script type="text/javascript" src="js/underscore.js"></script>
		<script type="text/javascript" src="js/jquery.hashchange-1.0.0.js"></script>
		<script type="text/javascript" src="js/printPage.js"></script>
		<script type="text/javascript" src="js/userFunc.js"></script>
		<script type="text/template" id="filterRecipes">
			<h2>Kategorier</h2>
			<p><a href="#">Visa alla recept</a></p>
			<ul>
	        <% for (var index = 0; index < categories.length; index++){ %>
	            <% var category = categories[index]; %>
	                <li><a href="#recipes/category/<%= category.id %>"><%= category.category %></a></li>
	        <% } %>
	        </ul>

	        <h2>Authors</h2>
	        <ul>
	        <% for (var index = 0; index < authors.length; index++){ %>
	            <% var author = authors[index]; %>
	            	<li><a href="#recipes/author/<%= author.id %>"><%= author.author %></a></li>
	        <% } %>
	        </ul>
		</script>
		<script type="text/template" id="listRecipes">
			<h2>Recept</h2>
			<ul>
			<% for (var index = 0; index < recipes.length; index++){ %>
				<% var recipe = recipes[index]; %>
				<li><a href="#recipes/recipe/<%= recipe.id %>"><%= recipe.title %></a></li>
			<% } %>
			</ul>
		</script>
		<script type="text/template" id="addRecipe">
			<h2>Lägg till recept</h2>
			<form id="addRecipe" action="index.php" method="post">
				<dl>
					<dt><label for="recipeTitle">Titel</label></dt>
						<dd><input type="text" id="recipeTitle" name="recipeTitle" /></dd>
					<dt><label for="recipeDescription">Beskrivning</label></dt>
						<dd><textarea id="recipeDescription" name="recipeDescription"></textarea></dd>
					<dt><label for="portions">Portioner</label</dt>
						<dd><input type="text" id="portions" name="portions" maxlength="3" size="3"/></dd>
					<dt><label for="selCategories">Kategorier</label></dt>
						<dd>
							<select id="selCategories" name="category">
								<option>Välj Kategori...</option>
								<% for(var index = 0; index < categories.length; index++){ %>
									<% var category = categories[index]; %>
									<option value="<%= category.id %>"><%= category.category %></option>
								<% } %>
							</select>
						</dd>
				</dl>
				<p><button id="saveRecipeBtn">Spara recept</button>
				<div id="ingredients">
				</div>
			</form>
		</script>
		<script type="text/template" id="displayRecipe">
			<h2><%= recInfo.title %></h2>
			<div>Portioner <span class="portions"><%= recInfo.portions %></span></div>
			<div><p><%= recInfo.description %></p></div>
			<h3>Ingredienser</h3>
			<ul>
				<% for(var index = 0; index < ingredients.length; index++){ %>
					<% ingredient = ingredients[index]; %>
					<li>
						<span><%= ingredient.amount %></span>
						<span><%= ingredient.unit %></span>
						<span><%= ingredient.ingredient %></span>
					</li>
				<% } %>
			</ul>
		</script>
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