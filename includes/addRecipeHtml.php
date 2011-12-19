<div id="sidebar">Sidebar goes here</div>
<div id="content">
	<h2>Lägg till recept</h2>
	<form id="addRecipe" action="index.php" method="post">
		<dl>
			<dt><label for="recipeTitle">Titel</label></dt>
				<dd><input type="text" id="recipeTitle" name="recipeTitle" /></dd>
			<dt><label for="recipeDescription">Beskrivning</label></dt>
				<dd><textarea id="recipeDescription" name="recipeDescription"></textarea></dd>
			<dt><label for="portions">Portioner</label</dt>
				<dd><input type="text" id="portions" name="portions" maxlength="3" size="3"/></dd>
		</dl>
		<div id="ingredients">
		<p><button id="addIngredient">+ Ingrediens</button></p>
		</div>
		<p><button id="addRecipeBtn">Lägg till recept</button></p>
	</form>
</div>