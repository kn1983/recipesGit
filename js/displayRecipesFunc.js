window.recUtilities.recMenu = function recMenu(){
	var url = "api/index.php/?/json/recipe/listCategories";
	$.getJSON(url, function(data){
		if(data.success === true){
			var categories = $('#categories');
			var title = $('<h2/>').text('Kategorier');
			var list = $('<ul/>');
			categories.empty();

			$.each(data.data.categories, function(index, value){
				var li = $('<li id="category' +  value.id + '">');
				var a = $('<a href="#">' + value.category + '</a>');

				//Create sub categories
				a.click(function(){
					var url = "api/index.php/?/json/recipe/listRecipes";
					$.post(url, {category: value.id}, function(data){
						if(data.success == true){
							var subCategories = li.find('ul');
							if(subCategories.length > 0){
								subCategories.remove();
							} else {
								var newSubCats = $('<ul/>');
								$.each(data.data.recipes, function(index, value){
									var newSubCat = $('<li><a href="#recipe/' + value.id + '">' + value.title + '</a></li>');
									newSubCats.append(newSubCat);
								});
								li.append(newSubCats);	
							}
						} else {
							console.debug("No recipes on this category!");
						}
					},"json");
				});
				li.append(a);
				list.append(li);
			});
				categories.append(list);
		} else {
			console.debug("Success false");
		}
	});
};
window.recUtilities.displayRecipe = function displayRecipe(args){
	var url = "api/index.php/?/json/recipe/display";
	$.post(url, args, function(data){
		if(data.success == true){
			var recipeContainer = $('#recipe');
			var recipe = data.data.recipe;
			var ingredients = data.data.ingredients;
			var title = $('<h2/>').text(recipe.title);
			var description = $('<p/>').text(recipe.description);
			var author = $('<p>Skapat av ' + recipe.author + '</p>')
			var portions = $('<p>Portioner ' + recipe.portions + '</p>');
			var ingContainer = $('<div/>').attr('id', 'ingredients');
			var ingTitle = $('<h3/>').text('Ingredienser');
			var ingList = $('<ul/>');
			recipeContainer.empty();
			ingContainer.append(ingTitle, ingList);
			recipeContainer.append(title, author, portions, ingContainer, description);

			$.each(ingredients, function(key, value){
				var li = $('<li><span class="amount">' + value.amount +'</span><span class="unit">' + value.unit + '</span><span class="ingredient">' + value.ingredient + '</span></li>')
				ingList.append(li);
				console.debug(value);
			});

		} else {
			console.debug('error');
		}
	},"json");
	
}

$(function(){
	window.recUtilities.recMenu();
});