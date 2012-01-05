// window.recUtilities.catMenu = function recMenu(){
// 	var url = "api/index.php/?/json/recipe/listCategories";
// 	$.getJSON(url, function(data){
// 		if(data.success === true){
// 			var categories = $('#categories');
// 			var title = $('<h2/>').text('Kategorier');
// 			var list = $('<ul/>');
// 			categories.empty();
// 			$.each(data.data.categories, function(index, value){
// 				var li = $('<li id="category' +  value.id + '">');
// 				var a = $('<a href="#category/' + value.id + '">' + value.category + '</a>');
// 				li.append(a);
// 				list.append(li);
// 			});
// 				categories.append(title, list);
// 		} else {
// 			console.debug("Success false");
// 		}
// 	});
// };
// window.recUtilities.authorMenu = function authorMenu(){
// 	var url = "api/index.php/?/json/recipe/listAuthors";
// 	$.getJSON(url, function(data){
// 		if(data.success === true){
// 			var authors = $('#authors');
// 			var title = $('<h2/>').text('Användares recept');
// 			var list = $('<ul/>');
// 			authors.empty();
// 			$.each(data.data.authors, function(index, value){
// 				var li = $('<li id="author' +  value.id + '">');
// 				var a = $('<a href="#author/' + value.id + '">' + value.author + '</a>');
// 				li.append(a);
// 				list.append(li);
// 			});
// 				authors.append(title, list);
// 		} else {
// 			console.debug("Success false");
// 		}
// 	});
// };
// window.recUtilities.listRecipes = function listRecipes(args){
// 	var url = "api/index.php/?/json/recipe/listRecipes";
// 	$.post(url, args, function(data){
// 		var content = $('.recipes #content');
// 		content.empty();
// 		if(data.success == true){
// 			var recipe = data.data.recipes;
// 			var ul = $('<ul/>');
// 			var title = $('<h2/>');
// 			$.each(recipe, function(index, value){
// 				console.debug(data);
// 				var li = $('<li><a href="#recipe/' + value.id + '">' + value.title + '</a></li>');
// 				ul.append(li);

// 				if(typeof args != "undefined" && 'category' in args){
// 					title.text(value.category);
// 				} else if (typeof args != "undefined" && 'author' in args){
// 					title.text(value.author);	
// 				} else {
// 					title.text("Alla recept");
// 				}
// 			});
// 			content.append(title, ul);
// 		} else {
// 			content.append("<p>Inga recept kunde hittas!</p>");
// 		}
// 	},"json");
// }

// window.recUtilities.displayRecipe = function displayRecipe(args){
// 	var url = "api/index.php/?/json/recipe/display";
// 	$.post(url, args, function(data){
// 		if(data.success == true){
// 			var content = $('.recipes #content');
// 			var recipe = data.data.recipe;
// 			var ingredients = data.data.ingredients;
// 			var title = $('<h2/>').text(recipe.title);
// 			var description = $('<p/>').text(recipe.description);
// 			var author = $('<p>Skapat av ' + recipe.author + '</p>')
// 			var portions = $('<p>Portioner ' + recipe.portions + '</p>');
// 			var ingContainer = $('<div/>').attr('id', 'ingredients');
// 			var ingTitle = $('<h3/>').text('Ingredienser');
// 			var ingList = $('<ul/>');
// 			content.empty();
// 			content.append(title, author, portions, ingContainer, description);
// 			content.append(ingTitle, ingList);

// 			$.each(ingredients, function(key, value){
// 				var li = $('<li><span class="amount">' + value.amount +'</span><span class="unit">' + value.unit + '</span><span class="ingredient">' + value.ingredient + '</span></li>')
// 				ingList.append(li);
// 			});

// 		} else {
// 			console.debug('error');
// 		}
// 	},"json");
	
// }

// $(function(){
// 	window.recUtilities.catMenu();
// 	window.recUtilities.authorMenu();
// });