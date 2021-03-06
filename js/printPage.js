recUti = {};
recUti.loggedIn = false;
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
	var sidebar = $('#sidebar');
	return {
		recipes: function(){
			var url = "api/index.php/?/json/recipe/getCatsAndAuthors";
			$.getJSON(url, function(data){
				var categories = data.data.categories;
				var authors = data.data.authors;
				if(data.success){
                    var output = _.template($('#sidebarRecipes').html(), { categories : categories, authors: authors });
        			var outputHtml = $(output);
        			sidebar.empty();
        			sidebar.append(outputHtml);
				}
			});
		},
		myRecipes: function(){
			if(recUti.loggedIn){
				var url = "api/index.php/?/json/recipe/listMyRecipes";
				$.getJSON(url, function(data){
					if(data.success){
						var recipes = data.data.recipes;
						var output = _.template($('#sidebarMyRecipes').html(), { recipes : recipes});
						sidebar.empty();
	        			sidebar.append(output);
					} else {
						var errors = data.errors;
						var content = $('#content');
						content.empty();
						$.each(errors, function(index, value){
							content.append('<p/>').text(value);
						});
					}
				});
			}
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
		var url = "api/index.php/?/json/recipe/getRecipeMyRecipes";
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
				var shoppingList = recUti.shoppinglist();
				outputHtml.find("#editRecipe").click(function(){
					$('#recInfoWrapper').addClass('hidden');
					$('#saveRecipeForm').removeClass('hidden');
				});
				outputHtml.find('#removeRecipe').click(recFunc.removeRecipe);
				outputHtml.find('.removeIng').click(recFunc.removeIngredient);
				outputHtml.find('.editIng').click(recFunc.editIngredient);
				outputHtml.find('#updateIng').click(recFunc.updateIngredient);
				outputHtml.find('#saveIng').click(recFunc.addIngredient);
				outputHtml.find('#saveRecipe').click(recFunc.editRecipe);
				outputHtml.find('#addToShoppinglist').click(shoppingList.add);


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
				// var url = "api/index.php/?/json/recipe/getFullRecipe";
				$.post(url, args, function(data){
					if(data.success){
						var recInfo = data.data.recipe.info;
						var ingredients = data.data.recipe.ingredients;
						if(typeof ingredients === "undefined"){
							ingredients = "";
						}
						var outputHtml = renderTemplate($('#contentDisplayRecipe'), {recInfo: recInfo, ingredients: ingredients});
						var shoppingList = recUti.shoppinglist();
						outputHtml.find('#addToShoppinglist').click(shoppingList.add);
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
			if(recUti.loggedIn){
				var args = {};
				args[subPage] = subPageId;
				if(typeof subPage !== "undefined"){
					args[subPage] = subPageId;
					displayRecipe(args);
				}
			} else {
				content.append('<p>För detta krävs det att du loggar in!');
			}
		},
		addRecipe: function(){
			if(recUti.loggedIn){
				var url = "api/index.php/?/json/recipe/getAllCategories";
				$.getJSON(url, function(data){
					var categories = data.data.categories;
					if(data.success && data.loggedIn){
						var outputHtml = renderTemplate($('#contentAddRecipe'), {categories : categories});
						var recipe = recUti.recipe();
						var formEls = outputHtml.find('input, textarea, select');
						var validate = recUti.validate();
						formEls.focus(validate.removeError);
						outputHtml.find('#addRecipeBtn').click(recipe.addRecipe);
					}
				});
			} else {
				content.append('<p>För detta krävs det att du loggar in!</p>');
			}
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
		},
		shoppinglist: function(){
			if(recUti.loggedIn){
				var url = "api/index.php/?/json/shoppinglist/get";
				$.getJSON(url, function(data){
					if(data.success){
						if(data.loggedIn){
							var listItems = data.data.listItems;
							var recipes = data.data.recipes;
							var outputHtml = renderTemplate($('#contentShoppinglist'), {recipes: recipes, listItems: listItems});
							var shopFunc = recUti.shoppinglist();
							outputHtml.find('.removeShListItem').click(shopFunc.remove);
						}
					} else {
						$.each(data.errors, function(index, value){
							$('#content').append('<p>' + value + '</p>');
						});
					}
				});
			} else {
				content.append('<p>För detta krävs det att du loggar in!</p>');
			}
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
	var user = recUti.user();
	if(recUti.loggedIn){
		var template = $('#headerLoggedIn');
		loadTemplate(template);
		$('#logout').click(user.logout);
	} else {
		var template = $('#headerLoggedOut');
		loadTemplate(template);
		$('#login').click(user.login);
	}
};
recUti.checkIfLoggedIn = function(){
	$.ajax({
		url: "api/index.php/?/json/user/checkLogin",
		type: 'post',
		dataType: 'json',
		success: function(data){
			if(data.data.login){
				recUti.loggedIn = true;
			} else {
				recUti.loggedIn = false;
			}
		},
		async: false
	});	
};

$(function(){
	recUti.checkIfLoggedIn();
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