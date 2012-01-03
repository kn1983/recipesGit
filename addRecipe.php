<?php require_once 'includes/phpHead.php'; ?>
<!DOCTYPE html>
<html>
	<?php require_once 'includes/headHtml.php' ?>
	<body>
		<div id="container">
			<?php require_once 'includes/headerHtml.php'; ?>
			<div id="sidebar">
				sidebar goes here
			</div>
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
						<dt><label for="selCategories">Kategorier</label></dt>
							<dd>
								<select id="selCategories" name="category">
									<option>Välj Kategori...</option>
								</select>
							</dd>
					</dl>
					<div id="ingredients">
					</div>
					<p><button id="addIngredient">+ Ingrediens</button></p>
					<p><button id="addRecipeBtn">Lägg till recept</button></p>
				</form>
			</div>
		</div>
	</body>
</html>