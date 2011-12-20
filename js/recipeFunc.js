window.recUtilities.addRecipe = function addRecipe(){
	var url = "api/index.php/?/json/recipe/add";
	var form = $('#addRecipe');
	var test = form.serialize();
	console.debug(test);
	$.post(url, form.serialize(), function(data){
		// console.debug(data.id);
	},"json");
	return false;
};

window.recUtilities.addIngRow = function addIngRow(){
	var row = $('<ul/>');
	var amount = $('<li/>').append($('<label>Mängd</label><input type="text" name="ingredients[amount][]" />'));
	var unit = $('<li/>').append($('<label>Enhet</label><input type="text" name="ingredients[unit][]" />'));
	var ingredient = $('<li/>').append($('<label>Ingrediens</label><input type="text" name="ingredients[ingredient][]" />'));
	var container = $('#ingredients');
	
	row.append(amount, unit, ingredient);
	container.append(row);
};

$(function(){
	$('#addRecipeBtn').click(window.recUtilities.addRecipe);
	$('#addIngredient').click(function(){
		window.recUtilities.addIngRow();
		return false;
	});
});