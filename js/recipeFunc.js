window.recUtilities.addRecipe = function addRecipe(){
	var url = "api/index.php/?/json/recipe/add";
	var form = $('#addRecipe');
	$.post(url, form.serialize(), function(data){
		console.debug(data);
	},"json");
};
$(function(){
	$('#addRecipeBtn').click(function(){
		window.recUtilities.addRecipe();
		return false;
	});
});