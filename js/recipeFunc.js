recUti.recipe = function(recipe){
	if(typeof recipe !== "undefined"){
		var renderContent = recUti.renderContent('myRecipes');
		var renderSidebar = recUti.renderSidebar('myRecipes');
	}
	var self = {
		addIngredient: function(){
			var form = $('#addIngForm');
			var ingData = form.serialize();
			var validate = recUti.validate(form);
			validate.form(form);
			if(validate.isValid){
				var url = "api/index.php/?/json/ingredient/add";
				$.post(url, ingData, function(data){
					if(data.success){
						renderContent.myRecipes('recipe', recipe);
					}
				},"json");
			}
			return false;
		},
		removeIngredient: function(){
			if(confirm("Är du säker på att du vill ta bort ingrediensen")){
				var recConId = $(this).data("recconid");
				var url = "api/index.php/?/json/ingredient/remove";
				$.post(url, {recipe: recipe, recConId: recConId}, function(data){
					if(data.success){
						renderContent.myRecipes('recipe', recipe);
					}
				},"json");
			}
		},
		editIngredient: function(){
			var ingId = $(this).data("recconid");
			console.debug(ingId);
			var ingRow = $('#ing_' + ingId);
			var ing = ingRow.find('.ingredient').text();
			var amount = ingRow.find('.amount').text();
			var unit = ingRow.find('.unit').data('unitid');
			$('#e_ingredient').val(ing);
			$('#e_amount').val(amount);
			$('#e_recConId').val(ingId);
			$("#e_unit").val(unit);
			self['dialog'] = recUti.dialog($('#updateIngDialog'));
			self.dialog.open();
		},
		updateIngredient: function(){
			var form = $('#updateIngForm')
			var ingData = form.serialize();
			var validate = recUti.validate(form);
			validate.form(form);
			if(validate.isValid){
				console.debug(ingData);
				var url = "api/index.php/?/json/ingredient/update";
				$.post(url, ingData, function(data){
					if(data.success){
						renderContent.myRecipes('recipe', recipe);
						if (typeof self.dialog){
							self.dialog.close();
						}
					}
				},"json");
			}
			return false;
		},
		addRecipe: function(){
			var form = $('#addRecForm');
        	var recData = form.serialize();
			var url = "api/index.php/?/json/recipe/add";
			var validate = recUti.validate(form);
			validate.form(form);
			if(validate.isValid){
				$.post(url, recData, function(data){
					if(data.success){
						var recipe = data.data.recipe;
						location.hash = "#myRecipes/recipe/" + recipe;
					}
				},"json");
			}
			return false;
		},
		editRecipe: function(){
			var form = $('#saveRecipeForm');
			var recipeData = form.serialize();
			var validate = recUti.validate(form);
			validate.form(form);
			if(validate.isValid){
				var url = "api/index.php/?/json/recipe/edit";
				$.post(url, recipeData, function(data){
					if(data.success){
						renderContent.myRecipes('recipe', recipe);
						renderSidebar.myRecipes();
					}
				},"json");
			}
			return false;
		}
	};
	return self;
};