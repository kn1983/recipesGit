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
		<script type="text/template" id="sidebarRecipes">
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
		<script type="text/template" id="contentRecipeList">
			<h2>Recept</h2>
			<ul>
			<% for (var index = 0; index < recipes.length; index++){ %>
				<% var recipe = recipes[index]; %>
				<li><a href="#recipes/recipe/<%= recipe.id %>"><%= recipe.title %></a></li>
			<% } %>
			</ul>
		</script>
		<script type="text/template" id="contentAddRecipe">
			<h2>Lägg till recept</h2>
			<form id="addRecForm" action="index.php" method="post">
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
								<option value="">Välj Kategori...</option>
								<% for(var index = 0; index < categories.length; index++){ %>
									<% var category = categories[index]; %>
									<option value="<%= category.id %>"><%= category.category %></option>
								<% } %>
							</select>
						</dd>
				</dl>
				<p><button id="saveRecipeBtn">Spara recept</button>
			</form>
			<div id="ingredients">
			</div>
		</script>
		<script type="text/template" id="contentDisplayRecipe">
			<h2><%= recInfo.title %></h2>
			<div>Portioner <span class="portions"><%= recInfo.portions %></span></div>
			<div><p><%= recInfo.description %></p></div>
			<% if(ingredients.length > 0){ %>
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
			<% } %>
		</script>
		<script type="text/template" id="sidebarMyRecipes">
			<h2>Mina recept</h2>
			<ul>
				<% for(var index = 0; index < recipes.length; index++){ %>
				<% var recipe = recipes[index]; %>
				<li><a href="#myRecipes/recipe/<%= recipe.id %>"><%= recipe.title %></a></li>
				<% } %>
			</ul>
		</script>
		<script type="text/template" id="contentMyRecipes">
			<div id="recInfoWrapper">
				<h2><%= recInfo.title %></h2>
				<div>Kategori <span class="category"><%= recInfo.category %></span></div>
				<div>Portioner <span class="portions"><%= recInfo.portions %></span></div>
				<div>
					<h3>Beskrivning</h3>
					<p><%= recInfo.description %></p>
				</div>
				<p><button id="editRecipe">Editera recept</button>
			</div>
			<form id="saveRecipeForm" class="hidden" method="post" action="index.php">
				<dl>
					<dt><label for="recipeTitle">Titel</label></dt>
					<dd><input type="text" id="recipeTitle"  name="recipeTitle" value="<%= recInfo.title %>" /></dd>

					<dt><label for="category">Kategori</label></dt>
					<dd>
						<select id="category" name="category">
							<% for(var index = 0; index < categories.length; index++){ %>
								<% var category = categories[index]; %>
								<% if(category.id == recInfo.categoryId){ %>
									<option value="<%= category.id %>" selected="selected"><%= category.category %></option>
								<% } else { %>
									<option value="<%= category.id %>"><%= category.category %></option>
								<% } %>
							<% } %>
						</select>
					</dd>

					<dt><label for="portions">Portioner</label></dt>
					<dd><input type="text" id="portions" name="portions" value="<%= recInfo.portions %>" /></dd>

					<dt><label for="recipeDescription">Beskrivning</label></dt>
					<dd><textarea id="recipeDescription" name="recipeDescription"><%= recInfo.description %></textarea></dd>
				</dl>

				<input type="hidden" name="recipe" id="recipe" value="<%= recInfo.id %>" />
				<p><button id="saveRecipe">Ändra</button></p>
			</form>
			<div class="ingredientsWrapper">
				<% if (ingredients.length > 0){ %>
					<h3>Ingredienser</h3>
					<ul>
						<% for(var index = 0; index < ingredients.length; index++){ %>
							<% ingredient = ingredients[index]; %>
							<li><button id="delIng_<%= ingredient.id %>"class="removeIng">X</button>
								<span><%= ingredient.amount %></span>
								<span><%= ingredient.unit %></span>
								<span><%= ingredient.ingredient %></span>
								<button class="editIng">Editera</button>
							</li>
						<% } %>
					</ul>
				<% } %>
				<p><button id="addIngredient">+ Ingrediens</button>
				<div id="newIngWrapper" class="hidden">
					<form id="addIngForm" method="post" action="index.php">
					<label for="ingredient">Ingrediens</label>
					<input type="text" name="ingredient" id="ingredient" />

					<label for="amount">Mängd</label>
					<input type="text" name="amount" id="amount" />

					<label for="unit">Enhet</label>
					<select id="units" name="unit">
						<option value="">Välj enhet</option>
						<% for(var index = 0; index < units.length; index++){%>
							<% var unit = units[index]; %>
							<option value="<%= unit.id %>"><%= unit.name%></option>
						<% } %>
					</select>
					<input type="hidden" name="recipe" value="<%= recInfo.id %>" />
					<button id="saveIng">Lägg till</button>	
					</form>					
				</div>
			</div>
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