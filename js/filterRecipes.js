$(function(){	
	updateState(location.hash);
	$(window).hashchange(function() { 
		updateState(location.hash); 
	});
	function updateState(state){
		var hashStr = state.substr(1);
		var urlParams = hashStr.split("/");
		var paramKey = urlParams[0];
		var paramVal = urlParams[1];
		var filter = recUti.filterRecipes();

		if(typeof filter[paramKey] !== "undefined" && typeof paramVal !== "undefined"){
			filter[paramKey](paramVal);
		} else {
			filter.allRecipes();
		}
	}
});