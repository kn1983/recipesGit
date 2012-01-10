recUti.myRecipes = function(){
	var sidebar = $('.myRecipes #sidebar');
	sidebar.empty();
	var ret = {
		listRecipes: function(){
			var url = "api/index.php/?/json/recipe/listRecipes";
			$.post(url, {myRecipes: true}, function(data){
				var ul = $('<ul/>');
				var recipes = data.data.recipes;
				$.each(recipes, function(index, value){
					var li = $('<li><a href="#">' + value.title + '</a></li>');
					ul.append(li);
				});
				sidebar.append(ul);
			},"json");
		},
		displayRecipe: function(){
				
		}
	};
	return ret;	
};
$(function(){
	var myRec = recUti.myRecipes();
	myRec.listRecipes();
});