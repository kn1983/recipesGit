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
        			$('#sidebar').html(outputHtml);
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
recUti.dialog = function(dialog){
	var dialogBg = $('.dialogBg');
	var self = {
		status: "CLOSED",
		closeBtn: $('.dialog .close').bind("click", function(event){
			self.close();
			return false;
		}),
		open: function(){
			dialogBg.removeClass('hidden');
			dialog.removeClass('hidden');
			self.status = "OPEN";
		},
		close: function(){
			dialogBg.addClass('hidden');
			dialog.addClass('hidden');
			self.status = "CLOSED";
		}	
	}
	return self;
}
recUti.recipe = function(recipe){
	var renderContent = recUti.renderContent('myRecipes');
	var renderSidebar = recUti.renderSidebar('myRecipes');
	var self = {
		addIngredient: function(){
			var ingData = $('#addIngForm').serialize();
			var url = "api/index.php/?/json/ingredient/add";
			$.post(url, ingData, function(data){
				if(data.success){
					renderContent.myRecipes('recipe', recipe);
				}
			},"json");
			return false;
		},
		removeIngredient: function(){
			if(confirm("Är du säker på att du vill ta bort ingrediensen")){
				var ingId = $(this).data("ingid");
				var url = "api/index.php/?/json/ingredient/remove";
				$.post(url, {recipe: recipe, ingredientId: ingredient}, function(data){
					if(data.success){
						renderContent.myRecipes('recipe', recipe);
					}
				},"json");
			}
		},
		editIngredient: function(){
			var ingId = $(this).data("ingid");
			console.debug(ingId);
			var ingRow = $('#ing_' + ingId);
			var ing = ingRow.find('.ingredient').text();
			var amount = ingRow.find('.amount').text();
			var unit = ingRow.find('.unit').data('unitid');
			$('#e_ingredient').val(ing);
			$('#e_amount').val(amount);
			$('#e_ingId').val(ingId);
			$("#e_unit").val(unit);
			self['dialog'] = recUti.dialog($('#updateIngDialog'));
			self.dialog.open();
		},
		updateIngredient: function(){
			var ingData = $('#updateIngForm').serialize();
			var url = "api/index.php/?/json/ingredient/update";
			$.post(url, ingData, function(data){
				if(data.success){
					renderContent.myRecipes('recipe', recipe);
					if (typeof self.dialog){
						self.dialog.close();
					}
				}
			},"json");
			return false;
		},
		editRecipe: function(){
			var recipeData = $('#saveRecipeForm').serialize();
			var url = "api/index.php/?/json/recipe/edit";
			$.post(url, recipeData, function(data){
				if(data.success){
					renderContent.myRecipes('recipe', recipe);
					renderSidebar.myRecipes();
				}
			},"json");
			return false;
		}
	}
	return self;
}
recUti.renderContent = function(page){
	var content = $('#content');
	function renderTemplate(template, data){
		if(typeof data === "undefined"){
			data = {};
		}
		var output = _.template(template.html(), data);
		var outputHtml = $(output);
		$('#content').append(outputHtml);
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
				var url = "api/index.php/?/json/recipe/getRecipeWithIng";
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
		},
		search: function(){
			var outputHtml = renderTemplate($('#contentSearch'));
        	var searchField = $('#searchField');
        	searchField.keyup(function(event){
        		var searchStr = $(this).val();
        		var resultDiv = $('#searchResult');
        		resultDiv.empty();
        		if(searchStr.length > 2){
        			recUti.searchFunc(searchStr, resultDiv);
        		}
        	});

        	$('#searchBtn').click(function(){
        		// console.debug(searchField);
        	});
		},
		signup: function(){
			var outputHtml = renderTemplate($('#contentSignup'));
		}
	}
	return self;
};
recUti.searchFunc = function(searchStr, resultDiv){
	var url = "api/index.php/?/json/search/searchAll";
	$.post(url, {searchStr: searchStr}, function(data){
		var resultTitel = $('<h2/>').text('Sökresultat');
		resultDiv.append(resultTitel);
		if(data.success){
			var searchResult = data.data.searchResult;
			var ul = $('<ul/>');
			$.each(searchResult, function(index, value){
				var title = value.title;
				var recId = value.id;
				var category = value.category;
				var li = $('<li><h3><a href="#recipes/recipe/' + value.id + '">' + value.title + '</a></h3><div>Kategori ' + value.category + '</div></li>');
				ul.append(li);
			});
			resultDiv.append(ul);
		} else {
			resultDiv.append('<p>Din sökning gav tyvärr inga träffar!</p>');
		}
	},"json");
};
recUti.loadHeader = function(){
	function loadTemplate(template){
		var output = _.template(template.html());
		$('#header').html(output);
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