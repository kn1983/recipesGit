window.recUtilities.addRecipe = function addRecipe(){
	var url = "api/index.php/?/json/recipe/add";
	var form = $('#addRecipe');

	console.debug(form.serialize());

	$.post(url, form.serialize(), function(data){
		if(data.success == true){
	// 		alert("success");
		}
	},"json");
	return false;
};

window.recUtilities.fetchCategories = function fetchCategories(){
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
		// console.debug(data);
		// if(data.success === true){

		// // Create main categories
		// var categories = $('#categories');
		// var title = $('<h2/>').text('Kategorier');
		// var list = $('<ul/>');
		// categories.empty();
		// $.each(data.data.categories, function(index, value){
}

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
		$.each(data.data.units, function(index, value){
			var option = $('<option/>').val(value.id).text(value.name);
			units.append(option);
		});
	});
	row.append(amount, unit, ingredient);
	container.append(row);
};

$(function(){
	window.recUtilities.fetchCategories();
	$('#addRecipeBtn').click(window.recUtilities.addRecipe);
	$('#addIngredient').click(function(){
		window.recUtilities.addIngRow();
		return false;
	});
});