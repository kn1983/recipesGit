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
        			var outputHtml = $(output);
        			$('#sidebar').append(outputHtml);
				}
			});
		},
		myRecipes: function(){
			var url = "api/index.php/?/json/recipe/listRecipes";
			$.post(url, {myRecipes: true}, function(data){
				if(data.success){
					var recipes = data.data.recipes;
					var output = _.template($('#sidebarMyRecipes').html(), { recipes : recipes} );
        			$('#sidebar').append(output);
				}
			},"json");
		}
	}
};
recUti.renderContent = function(page){
	var content = $('#content');
	function renderTemplate(template, data){
		if(typeof data === "undefined"){
			data = {};
		}
		var output = _.template(template.html(), data);
		var outputHtml = $(output);
		$('#content').append(outputHtml);
		var formEls = outputHtml.find('input, textarea, select');
		var validate = recUti.validate();
		formEls.focus(validate.removeError);
		return outputHtml;
	}
	content.empty();
	function displayRecipe(args, template){
		var url = "api/index.php/?/json/recipe/getRecipeIngUnitsAndCats";
		$.post(url, args, function(data){
			if(data.success){
				var recInfo = data.data.recipe.info;
				var recFunc = recUti.recipe(recInfo.id);
				var ingredients = data.data.recipe.ingredients;
				if(typeof ingredients === "undefined"){
					ingredients = "";
				}
				var units = data.data.units;
				var categories = data.data.categories;
				var outputHtml = renderTemplate($('#contentMyRecipes'), {recInfo: recInfo, ingredients: ingredients, units: units, categories: categories});
				outputHtml.find("#editRecipe").click(function(){
					$('#recInfoWrapper').addClass('hidden');
					$('#saveRecipeForm').removeClass('hidden');
				});
				outputHtml.find('.removeIng').click(recFunc.removeIngredient);
				outputHtml.find('.editIng').click(recFunc.editIngredient);
				outputHtml.find('#updateIng').click(recFunc.updateIngredient);
				outputHtml.find('#saveIng').click(recFunc.addIngredient);
				outputHtml.find('#saveRecipe').click(recFunc.editRecipe);
			}
		},"json");
	}
	var self = {
		recipes: function(subPage, subPageId){
			var args = {};
			args[subPage] = subPageId;
			if(typeof subPage !== "undefined"){
				args[subPage] = subPageId;
			}
			if(typeof subPage !== "undefined" && subPage === 'recipe'){
				var url = "api/index.php/?/json/recipe/getRecipeIngUnitsAndCats";
				$.post(url, args, function(data){
					if(data.success){
						var recInfo = data.data.recipe.info;
						var ingredients = data.data.recipe.ingredients;
						if(typeof ingredients === "undefined"){
							ingredients = "";
						}
						var outputHtml = renderTemplate($('#contentDisplayRecipe'), {recInfo: recInfo, ingredients: ingredients});
					}
				},"json");
			} else {
				var url = "api/index.php/?/json/recipe/listRecipes";
				$.post(url, args, function(data){
					if(data.success){
						var recipes = data.data.recipes;
						if(data.success){
							var outputHtml = renderTemplate($('#contentRecipeList'), {recipes: recipes});
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
		
			displayRecipe(args);
		},
		addRecipe: function(){
			var url = "api/index.php/?/json/recipe/getAllCategories";
			$.getJSON(url, function(data){
				var categories = data.data.categories;
				if(data.success){
					var outputHtml = renderTemplate($('#contentAddRecipe'), {categories : categories});
					var recipe = recUti.recipe();
					var formEls = outputHtml.find('input, textarea, select');
					var validate = recUti.validate();
					formEls.focus(validate.removeError);
					outputHtml.find('#saveRecipeBtn').click(recipe.addRecipe);

				}
			});
		},
		search: function(){
			var outputHtml = renderTemplate($('#contentSearch'));
        	var searchField = $('#searchField');
        	var resultDiv = $('#searchResult');
        	searchField.keyup(function(event){
        		var searchStr = $(this).val();
        		if(searchStr == ""){
        			resultDiv.empty();
        		}
        		if(searchStr.length > 2){
        			recUti.searchFunc(searchStr, resultDiv);
        		}
        	});

        	$('#searchBtn').click(function(){
        		var searchStr = $('#searchField').val();
        		recUti.searchFunc(searchStr, resultDiv);
        	});
		},
		signup: function(){
			var outputHtml = renderTemplate($('#contentSignup'));
			var user = recUti.user();
			outputHtml.find('#signupUser').click(user.signup);
		}
	}
	return self;
};
recUti.loadHeader = function(){
	function loadTemplate(template){
		var output = _.template(template.html(), {});
		var outputHtml = $(output);
		$('#header').empty();
		$('#header').append(outputHtml);
		var formEls = outputHtml.find('input');
		var validate = recUti.validate();
		formEls.focus(validate.removeError);


	}
	var url ="api/index.php/?/json/user/checkLogin";
	$.getJSON(url, function(data){
		if(data.success){
			var user = recUti.user();
			if(data.data.login){
				var template = $('#headerLoggedIn');
				loadTemplate(template);
				$('#logout').click(user.logout);

			} else {
				var template = $('#headerLoggedOut');
				loadTemplate(template);
				$('#login').click(user.login);
			}
		}
	});
};
$(function(){
	recUti.loadHeader();
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