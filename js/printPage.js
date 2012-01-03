$(function(){
	var pages = {
		category: function(param){
			var args = {
				category: param
			};
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

		if(typeof pages[paramKey] !== "undefined" && typeof paramVal !== "undefined"){
			pages[paramKey](paramVal);
		} else {
			window.recUtilities.listRecipes();
		}
	}
});