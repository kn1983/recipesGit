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
			console.debug(self);
		},
		close: function(){
			dialogBg.addClass('hidden');
			dialog.addClass('hidden');
			self.status = "CLOSED";
			console.debug(self);
		}	
	}
	return self;
}
recUti.recipe = function(recipe){
	var renderContent = recUti.renderContent('myRecipes');
	var renderSidebar = recUti.renderSidebar('myRecipes');
	var self = {
		addIngredient: function(ingData){
			var url = "api/index.php/?/json/ingredient/add";
			$.post(url, ingData, function(data){
				if(data.success){
					renderContent.myRecipes('recipe', recipe);
				}
			},"json");
		},
		removeIngredient: function(ingredient){
			var url = "api/index.php/?/json/ingredient/remove";
			$.post(url, {recipe: recipe, ingredientId: ingredient}, function(data){
				if(data.success){
					renderContent.myRecipes('recipe', recipe);
				}
			},"json");
		},
		editIngredient: function(ingredient){
			var ingRow = $('#ing_' + ingredient);
			var ing = ingRow.find('.ingredient').text();
			var amount = ingRow.find('.amount').text();
			var unit = ingRow.find('.unit').data('unitid');
			self['dialog'] = recUti.dialog($('#updateIngDialog'));
			self.dialog.open();
			console.debug(self);

			$('#e_ingredient').val(ing);
			$('#e_amount').val(amount);
			$('#e_ingId').val(ingredient);
			$("#e_unit").val(unit);
		},
		updateIngredient: function(ingData){
			var url = "api/index.php/?/json/ingredient/update";
			$.post(url, ingData, function(data){
				if(data.success){
					renderContent.myRecipes('recipe', recipe);
					if (typeof self.dialog){
						self.dialog.close();
					}
				}
			},"json");
		},
		editRecipe: function(recipeData){
			var url = "api/index.php/?/json/recipe/edit";
			$.post(url, recipeData, function(data){
				if(data.success){
					renderContent.myRecipes('recipe', recipe);
					// renderSidebar.myRecipes();
				}
			},"json");
		}
	}
	return self;
}
recUti.renderContent = function(page){
	var content = $('#content');
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
				var output = _.template(template.html(), {recInfo: recInfo, ingredients: ingredients, units: units, categories: categories});
				var outputHtml = $(output);
				$('#content').append(outputHtml);
				outputHtml.find("#editRecipe").click(function(){
					$('#recInfoWrapper').addClass('hidden');
					$('#saveRecipeForm').removeClass('hidden');
				});
				var saveRecipe = $('#saveRecipe');
				saveRecipe.click(function(){
					var recipeData = $('#saveRecipeForm').serialize();
					recFunc.editRecipe(recipeData);
					return false;
				});





				var removeIng = $('.removeIng');
				removeIng.click(function(){
					if(confirm("Är du säker på att du vill ta bort ingrediensen")){
						var ingId = $(this).data("ingid");
						recFunc.removeIngredient(ingId);
					}
				});

				var editIng = $('.editIng');
				editIng.click(function(){
					var ingId = $(this).data("ingid");
					recFunc.editIngredient(ingId);
					return false;
				});

				var updateIng = $('#updateIng');
				updateIng.click(function(){
					var ingData = $('#updateIngForm').serialize();
					recFunc.updateIngredient(ingData);
					return false;
				});

				var saveIng = $('#saveIng');
				saveIng.click(function(){
					var ingForm = $('#addIngForm').serialize();
					recFunc.addIngredient(ingForm);
					return false;
				});
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
		},
		search: function(){
			var template = $('#contentSearch');
			var output = _.template(template.html());
        	$('#content').html(output);

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
			var template = $('#contentSignup');
			var output = _.template(template.html());
			$('#content').html(output);
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