recUti = {};
recUti.renderPage = function(page, urlParams){
	var body = $('body');
	var sidebar = body.find('#sidebar');
	var content = body.find('#content');
	var prevBodyId = $('body').attr('id');
	var cont = recUti.renderContent(page);
	var rendSidebar = recUti.renderSidebar();

	if(page !==""){
		body.attr('id', page);
	} else {
		body.attr('id', 'recipes');
	}

	//Render sidebar
	var curBodyId = $('body').attr('id');
	if(prevBodyId !== curBodyId){
		sidebar.removeClass('loaded');
		sidebar.empty();
		if(typeof rendSidebar[page] !== "undefined"){
			rendSidebar[page](page);
		}
	}

	//Render content
	content.empty();
	if(typeof cont[page] !== "undefined"){
		if(urlParams.length > 1){
			var subPage = urlParams[0];
			var subPageId = urlParams[1];
			cont[page](subPage, subPageId);
		} else {
			cont[page]();
		}
	}
};
recUti.renderSidebar = function(page){
	return {
		recipes: function(){
			var url = "api/index.php/?/json/recipe/getCatsAndAuthors";
			$.getJSON(url, function(data){
				var categories = data.data.categories;
				var authors = data.data.authors;
				if(data.success){
                    var output = _.template($('#sidebarRecipes').html(), { categories : categories, authors: authors } );
        			$('#sidebar').html(output);
				}
			});
		},
		myRecipes: function(){
			var url = "api/index.php/?/json/recipe/listRecipes";
			$.post(url, {myRecipes: true}, function(data){
				if(data.success){
					var recipes = data.data.recipes;
					var output = _.template($('#sidebarMyRecipes').html(), { recipes : recipes} );
        			$('#sidebar').html(output);
				}
			},"json");
		}
	}
};
recUti.recipe = function(recipe){
	return {
		addIngredient: function(ingData){
			var url = "api/index.php/?/json/ingredient/add";
			$.post(url, ingData, function(data){
				if(data.success){
					var cont = recUti.renderContent('myRecipes');
					cont.myRecipes('recipe', recipe);
				}
			},"json");
		},
		removeIng: function(ingredient){
			var url = "api/index.php/?/json/ingredient/remove";
			$.post(url, {recipe: recipe, ingredient: ingredient}, function(data){
				if(data.success){
					var cont = recUti.renderContent('myRecipes');
					cont.myRecipes('recipe', recipe);
				}
			},"json");
		}
	}
}
recUti.renderContent = function(page){
	var content = $('#content');
	function displayRecipe(args, template){
		var url = "api/index.php/?/json/recipe/getRecipeWithIng";
		$.post(url, args, function(data){
			if(data.success){
				var recInfo = data.data.recipe.info;
				var recFunc = recUti.recipe(recInfo.id);
				var ingredients = data.data.recipe.ingredients;
				if(typeof ingredients === "undefined"){
					ingredients = "";
				}
				url = "api/index.php/?/json/units/get";
				$.getJSON(url, function(data){
					var units = data.data.units;
					var output = _.template(template.html(), {recInfo: recInfo, ingredients: ingredients, units: units});
					$('#content').html(output);
					var addIng = $('#addIngredient');
					addIng.click(function(){
						$(this).hide();
						$('#newIngWrapper').removeClass('hidden');
						return false;
					});

					var removeIng = $('.removeIng');
					removeIng.click(function(){
						if(confirm("Är du säker på att du vill ta bort ingrediensen")){
							var id = $(this).attr('id');
							var ingId = id.substring(id.indexOf('_')+1, id.length);
							recFunc.removeIng(ingId);
						}
					});
					var addIng = $('#saveIng');
					addIng.click(function(){
						var ingForm = $('#addIngForm').serialize();
						recFunc.addIngredient(ingForm);
						return false;
					});
				});
			}
		},"json");
	}
	var ret = {
		recipes: function(subPage, subPageId){
			var args = {};
			args[subPage] = subPageId;
			if(typeof subPage !== "undefined"){
				args[subPage] = subPageId;
			}
			if(typeof subPage !== "undefined" && subPage === 'recipe'){
				var template = $('#contentDisplayRecipe');
				var url = "api/index.php/?/json/recipe/getRecipeWithIng";
				$.post(url, args, function(data){
					if(data.success){
						var recInfo = data.data.recipe.info;
						var ingredients = data.data.recipe.ingredients;

						if(typeof ingredients === "undefined"){
							ingredients = "";
						}
						var output = _.template(template.html(), {recInfo: recInfo, ingredients: ingredients});
						$('#content').html(output);
					}
				},"json");
			} else {
				var url = "api/index.php/?/json/recipe/listRecipes";
				$.post(url, args, function(data){
					if(data.success){
						var recipes = data.data.recipes;
						if(data.success){
		                    var output = _.template($('#contentRecipeList').html(), {recipes: recipes});
		        			$('#recipes #content').html(output);
						}
					} else {
						content.append("<p>Inga recept kunde hittas</p>");
					}
				},"json");			
			}	
		},
		myRecipes: function(subPage, subPageId){
			var args = {};
			args[subPage] = subPageId;
			if(typeof subPage !== "undefined"){
				args[subPage] = subPageId;
			}
			var template = $('#contentMyRecipes');
			displayRecipe(args, template);
		},
		addRecipe: function(){
			var url = "api/index.php/?/json/recipe/getAllCategories";
			$.getJSON(url, function(data){
				var categories = data.data.categories;
				if(data.success){
                    var output = _.template($('#contentAddRecipe').html(), { categories : categories} );
        			$('#content').html(output);
        			$('#saveRecipeBtn').click(function(){
        				var recData = $('#addRecForm').serialize();
						var url = "api/index.php/?/json/recipe/add";
						$.post(url, recData, function(data){
							if(data.success){
								var recipe = data.data.recipe;
								location.hash = "#myRecipes/recipe/" + recipe;
							}
						},"json");
						return false;
					});
				}
			});
		}
	}
	return ret;
};

$(function(){
	updateState(location.hash);
	$(window).hashchange(function() { 
		updateState(location.hash); 
	});
	function updateState(state){
		var hashStr = state.substr(1);
		var urlParams = hashStr.split("/");
		var page = urlParams.shift();
		if(page === ""){
			page = 'recipes';
		}
		recUti.renderPage(page, urlParams);
	}
});