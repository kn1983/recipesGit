recUti.addRecipe = function addRecipe(){
	var url = "api/index.php/?/json/recipe/add";
	var form = $('#addRecipe');

	$.post(url, form.serialize(), function(data){
		if(data.success == true){
	// 		alert("success");
		}
	},"json");
	return false;
};

recUti.fetchCategories = function fetchCategories(){
	var url = "api/index.php/?/json/recipe/listCategories";
	$.getJSON(url, function(data){
		if(data.success == true){
			var categories = data.data.categories;
			var select = $('#selCategories');
			$.each(categories, function(index, value){
				var option = $('<option/>').val(value.id).text(value.category);
				select.append(option);
			})
		} else {
			console.debug("Couldnt find the categories");
		}
	});
}

recUti.addIngRow = function addIngRow(){
	var row = $('<ul/>').addClass('ingredientRow');
	var container = $('#ingredients');
	var ingNum = container.find('.ingredientRow').length;
	var amount = $('<li/>').append($('<label>Mängd</label><input type="text" name="ingredients['+ ingNum +'][amount]" />'));
	var units = $('<select/>').append('<option>Välj enhet...</option>').addClass('units').attr('name', 'ingredients['+ ingNum +'][unit]');
	var unit = $('<li/>').append($('<label>Enhet</label>'), units);
	var ingredient = $('<li/>').append($('<label>Ingrediens</label><input type="text" name="ingredients['+ ingNum +'][ingredient]" />'));
	var url = "api/index.php/?/json/units/get";

	$.getJSON(url, function(data){
		$.each(data.data.units, function(index, value){
			var option = $('<option/>').val(value.id).text(value.name);
			units.append(option);
		});
	});
	row.append(amount, unit, ingredient);
	container.append(row);
};

recUti.filterRecipes = function(){
	var content = $('.recipes #content');
	content.empty();

	function listRecipes(args){
		var url = "api/index.php/?/json/recipe/listRecipes";
		$.post(url, args, function(data){
			if(data.success == true){
				var recipe = data.data.recipes;
				var ul = $('<ul/>');
				var title = $('<h2/>');
				$.each(recipe, function(index, value){
					var li = $('<li><a href="#recipe/' + value.id + '">' + value.title + '</a></li>');
					ul.append(li);

					if(typeof args != "undefined" && 'category' in args){
						title.text(value.category);
					} else if (typeof args != "undefined" && 'author' in args){
						title.text(value.author);	
					} else {
						title.text("Alla recept");
					}
				});
				content.append(title, ul);
			} else {
				content.append("<p>Inga recept kunde hittas!</p>");
			}
		},"json");
	}

	return {
		allRecipes: function(){
			listRecipes();
		},
		category: function(param){
			var args = {
				category: param
			};
			listRecipes(args);
		},
		author: function(param){
			var args = {
				author: param
			}
			listRecipes(args);	
		},
		recipe: function(param){
			var args = {
				recipe: param	
			};
			var url = "api/index.php/?/json/recipe/display";
			$.post(url, args, function(data){
				if(data.success == true){
					var recipe = data.data.recipe;
					var ingredients = data.data.ingredients;
					var title = $('<h2/>').text(recipe.title);
					var description = $('<p/>').text(recipe.description);
					var author = $('<p>Skapat av ' + recipe.author + '</p>')
					var portions = $('<p>Portioner ' + recipe.portions + '</p>');
					var ingContainer = $('<div/>').attr('id', 'ingredients');
					var ingTitle = $('<h3/>').text('Ingredienser');
					var ingList = $('<ul/>');
				
					content.append(title, author, portions, ingContainer, description);
					content.append(ingTitle, ingList);

					$.each(ingredients, function(key, value){
						var li = $('<li><span class="amount">' + value.amount +'</span><span class="unit">' + value.unit + '</span><span class="ingredient">' + value.ingredient + '</span></li>')
						ingList.append(li);
					});

				} else {
					console.debug('error');
				}
			},"json");
		}
	}
};

recUti.sidebarMenu = function(sidebar){
	sidebar.empty();
	sidebar.append('<p><a href="#">Visa alla recept</a></p>');

	return {
		addMenu: function(url, menuItems, title, fieldName){
			$.getJSON(url, function(data){
				if(data.success === true){
					var menuContainer = $('<div/>');
					var sidebarTitle = $('<h2/>').text(title);
					var list = $('<ul/>');
					$.each(data.data[menuItems], function(index, value){
						var li = $('<li id="' + fieldName +  value.id + '">');
						var a = $('<a href="#' + fieldName + '/' + value.id + '">' + value[fieldName] + '</a>');
						li.append(a);
						list.append(li);
					});
						menuContainer.append(sidebarTitle, list);
						sidebar.append(menuContainer);
				} else {
					console.debug("Success false");
				}
			});
		}
	}
};

$(function(){
	var menu = recUti.sidebarMenu($('.recipes #sidebar'));
	menu.addMenu("api/index.php/?/json/recipe/listCategories", "categories", "Kategorier", "category");
	menu.addMenu("api/index.php/?/json/recipe/listAuthors", "authors", "Användarnas recept", "author");
	recUti.fetchCategories();
	
	$('#addRecipeBtn').click(recUti.addRecipe);
	$('#addIngredient').click(function(){
		recUti.addIngRow();
		return false;
	});
});