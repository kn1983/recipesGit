window.recUtilities.addRecipe = function addRecipe(){
	var url = "api/index.php/?/json/recipe/add";
	var form = $('#addRecipe');

	$.post(url, form.serialize(), function(data){
		if(data.success == true){
			alert("success");
		}
	},"json");
	return false;
};

window.recUtilities.addIngRow = function addIngRow(){
	var row = $('<ul/>').addClass('ingredientRow');
	var container = $('#ingredients');
	var ingNum = container.find('.ingredientRow').length;
	var amount = $('<li/>').append($('<label>Mängd</label><input type="text" name="ingredients['+ ingNum +'][amount]" />'));
	var units = $('<select/>').append('<option>Välj enhet...</option>').addClass('units').attr('name', 'ingredients['+ ingNum +'][unit]');
	var unit = $('<li/>').append($('<label>Enhet</label>'), units);
	var ingredient = $('<li/>').append($('<label>Ingrediens</label><input type="text" name="ingredients['+ ingNum +'][ingredient]" />'));
	var url = "api/index.php/?/json/units/get";

	$.getJSON(url, function(data){
		$.each(data.data, function(index, value){
			var option = $('<option/>').val(value.id).text(value.name);
			units.append(option);
		});
	});
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