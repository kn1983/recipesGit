// window.recUtilities.createCatMenu = function createCatMenu(data){
// 	var categories = $('#categories');
// 	var title = $('<h2/>').text('Kategorier');
// 	var list = $('<ul/>');
// 	categories.empty();
// 	$.each(data.data, function(index, value){
// 		var li = $('<li id="category' +  value.id + '"><a href="#category/' + value.id + '">' + value.category + '</a></li>');
// 		list.append(li);
// 	});
// 	categories.append(list);
// };


// window.recUtilities.createCatMenu = function createCatMenu(data){
// 	var categories = $('#categories');
// 	var title = $('<h2/>').text('Kategorier');
// 	var list = $('<ul/>');
// 	categories.empty();
// 	$.each(data.data, function(index, value){
// 		var li = $('<li id="category' +  value.id + '">');
// 		var a = $('<a href="#">' + value.category + '</a>');
// 		a.blabla = "teeeest";
// 		a.bind("click", window.recUtilities.listRecipes);
// 		console.debug(a);
// 		li.append(a);
// 		list.append(li);
// 	});
// 	categories.append(list);
// };

window.recUtilities.recMenu = function recMenu(){
	var url = "api/index.php/?/json/recipe/listCategories";
	$.getJSON(url, function(data){
		// console.debug(data);
		if(data.success === true){

		// Create main categories
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
			var recipeTitle = $('<h2/>').text(recipe.title);
			recipeContainer.empty();
			recipeContainer.append(recipeTitle);



			// var recipe = data.data[0];
			// console.debug(recipe.recipe);
		} else {
			console.debug('error');
		}
	},"json");
	
}
// window.recUtilities.listRecipes = function listRecipes(){
// 	var url = "api/index.php/?/json/recipe/listRecipes";
// 	if(typeof args == "undefined"){
// 		args = "";
// 	}
// 	var catId = args.category;
// 	var li = $('#category' + catId);
// 	console.debug(li);

// 	$.post(url, args, function(data){
// 		// var recCon = $('#listRecipes');
// 		// recCon.empty();
// 		if(data.success === true){
// 			$.each(data.data, function(index, value){
// 				var category = value.category;
// 				var li = $('#');
// 				// var row = $('<li/><a href="#">' + value.title + '</a></li>');
// 				// recipes.append(row);
// 			});
// 			// recCon.append(recipes);
// 		} else {

// 			// recCon.text('Det finns inga recept under denna kategori!');
// 		} 
// 	},"json");
// };
// window.recUtilities.listRecipes = function listRecipes(args){
// 	var url = "api/index.php/?/json/recipe/listRecipes";
// 	if(typeof args == "undefined"){
// 		args = "";
// 	}
// 	var catId = args.category;
// 	var li = $('#category' + catId);
// 	console.debug(li);

// 	$.post(url, args, function(data){
// 		// var recCon = $('#listRecipes');
// 		// recCon.empty();
// 		if(data.success === true){
// 			$.each(data.data, function(index, value){
// 				var category = value.category;
// 				var li = $('#');
// 				// var row = $('<li/><a href="#">' + value.title + '</a></li>');
// 				// recipes.append(row);
// 			});
// 			// recCon.append(recipes);
// 		} else {

// 			// recCon.text('Det finns inga recept under denna kategori!');
// 		} 
// 	},"json");
// };
// window.recUtilities.listCategories = function listCategories(){
// 	var url = "api/index.php/?/json/recipe/listCategories";
// 	$.getJSON(url, function(data){
// 		if(data.success === true){
// 			window.recUtilities.createCatMenu(data);
// 		}
// 	});
// }
// window.recUtilities.listAuthors = function listAuthors(){
// 	var url = "api/index.php/?/json/recipe/listAuthors";
// 	$.getJSON(url, function(data){
// 		console.debug(data);
// 	});
// }


$(function(){
	window.recUtilities.recMenu();
	// window.recUtilities.listRecipes();
	// window.recUtilities.listCategories();
});