// window.recUtilities.listRecipes = function listRecipes(){
// 	var url = "api/index.php/?/json/recipe/listRecipes";
// 	$.getJSON(url, function(data){
// 		var recipes = $('#recipes');
// 		var list = $('<ul/>');
// 		recipes.empty();
// 		$.each(data.data, function(key, value){
// 			var row = $('<li><span><a href="?page=recipe&id=' + value.id + '">' + value.title + '</span><span>Skapat av ' + value.user + '</span></li>');
// 			var recipeTitle = value.title;
// 			var author = value.user;
// 			list.append(row);
// 		});
// 		recipes.append(list);
// 		console.debug(data);
// 	});
// };

// $(function(){
// 	window.recUtilities.listRecipes();
// });