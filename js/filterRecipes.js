$(function(){
	var filter = {
		category: function(param){
			var args = {
				category: param
			};
			window.recUtilities.listRecipes(args);
		},
		author: function(param){
			var args = {
				author: param
			}
			window.recUtilities.listRecipes(args);	
		},
		recipe: function(param){
			var args = {
				recipe: param	
			};
			window.recUtilities.displayRecipe(args);
		}	
	};


	updateState(location.hash);
	$(window).hashchange(function() { 
		updateState(location.hash); 
	});
	function updateState(state){
		var hashStr = state.substr(1);
		var urlParams = hashStr.split("/");
		var paramKey = urlParams[0];
		var paramVal = urlParams[1];

		if(typeof filter[paramKey] !== "undefined" && typeof paramVal !== "undefined"){
			filter[paramKey](paramVal);
		} else {
			window.recUtilities.listRecipes();
		}
	}
});