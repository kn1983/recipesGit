recUti = {};
recUti.renderPage = function(page){
	var body = $('body');
	var sidebar = body.find('#sidebar');
	var content = body.find('#content');
	var prevBodyId = $('body').attr('id');

	if(page !=""){
		body.attr('id', page);
	} else {
		body.attr('id', 'recipes');
	}

	var curBodyId = $('body').attr('id');

	if(prevBodyId !== curBodyId){
		sidebar.removeClass('loaded');
		sidebar.empty();
	}

	content.empty();
	
	function loadSidebar(url){
		if(prevBodyId !== curBodyId){
			$.get(url, function(data){
				sidebar.append(data);
				sidebar.addClass('loaded');
			});
		}
	}
	var ret = {
		recipes: function(){
			var url = "api/views/sidebarRecipes.html";
			loadSidebar(url);

			//Render Category menu
			var url = "api/index.php/?/json/recipe/listCategories";
			$.getJSON(url, function(data){
				if(data.success){
					var cats = data.data.categories;
					var catMenu = $('#catMenu');
					catMenu.empty();
					$.each(cats, function(index, value){
						var row = $('<li><a href="#recipes/category/' + value.id + '">' + value.category + '</a></li>');
						catMenu.append(row);
					});
				}
			});

			//Render Author meny
			var url = "api/index.php/?/json/recipe/listAuthors";
			$.getJSON(url, function(data){
				if(data.success){
					var authors = data.data.authors;
					var authorMenu = $('#authorMenu');
					authorMenu.empty();
					$.each(authors, function(index, value){
						var row = $('<li><a href="#recipes/author/' + value.id + '">' + value.author + '</a></li>');
						authorMenu.append(row);
					});
				}
			});	
		},
		signup: function(){
			var url = "api/views/contentSignup.html";
			$.get(url, function(data){
				content.append(data);
			});	
		},
		addRecipe: function(){
			var url = "api/views/contentAddRecipe.html";
			$.get(url, function(data){
				content.append(data);
			});	
		},
		myRecipes: function(){
			console.debug("My Recipes");
		},
		search: function(){
			console.debug("Searach");
		}	
	}	
	return ret;	
};
recUti.renderSubPage = function(subPage, subPageId){
	function filterRecipes(args){
		if(typeof subPageId === "undefined"){
			args = {};	
		}
		var content = $('#recipes').find('#content');
		content.empty();
		var url = "api/index.php/?/json/recipe/listRecipes";
		$.post(url, args, function(data){
			if(data.success){
				var recipes = data.data.recipes;
				var recipeContainer = $('<div/>').attr('class', 'recipes');
				var title = $('<h2/>').text('Recept');
				var list = $('<ul/>');
				recipeContainer.append(title, list);
				$.each(recipes, function(index, value){
					var row = $('<li><a href="#recipes/recipe/' + value.id + '">' + value.title + '</a>');
					list.append(row);
				});
				content.append(recipeContainer);
			} else {
				content.append("<p>Inga recept kunde hittas</p>");
			}
		},"json");
	}
	return {
		allRecipes: function(){
			filterRecipes();	
		},
		category: function(){
			var args = {category: subPageId};
			filterRecipes(args);
		},
		author: function(){
			var args = {author: subPageId};
			filterRecipes(args);
			
		},
		recipe: function(){
			var content = $('#recipes').find('#content');
			var url = "api/index.php/?/json/recipe/get";
			$.post(url, {recipe: subPageId}, function(data){
				if(data.success){
					var recInfo = data.data.recipe.info;
					var ingredients = data.data.recipe.ingredients;
					var title = $('<h2/>').text(recInfo.title);
					var description = $('<div/>').addClass('description').append('<p/>').text(recInfo.description);
					var portions = $('<div><span>Portioner</span><span>' + recInfo.portions + '</span></div>');
					var ingContainer = $('<div/>');
					var ingList = $('<ul/>');
					ingContainer.append(ingList);
					content.append(title, portions, description, ingContainer);
					$.each(ingredients, function(index, value){
						var row = $('<li><span>' + value.amount + '</span><span>' + value.unit + '</span><span>' + value.ingredient + '</span></li>');
						ingList.append(row);
					});
				}
			},"json");
		}
	}
}

$(function(){	
	updateState(location.hash);
	$(window).hashchange(function() { 
		updateState(location.hash); 
	});
	function updateState(state){
		var hashStr = state.substr(1);
		var urlParams = hashStr.split("/");
		var page = urlParams[0];
		var subPage = urlParams[1];
		var subPageId = urlParams[2];
		var renderPage = recUti.renderPage(page);
		var renderSubPage = recUti.renderSubPage(subPage, subPageId);
		
		//Render page
		if(typeof renderPage[page] !== "undefined"){
			renderPage[page]();
		} else {
			renderPage['recipes']();
		}

		//Render subpage
		if(typeof renderSubPage[subPage] !== "undefined"){
			renderSubPage[subPage](subPageId);
		} else {
			renderSubPage['allRecipes']();
		}
	}
});