recUti.searchFunc = function(searchStr, resultDiv){
	var url = "api/index.php/?/json/search/searchAll";
	if(searchStr == ""){
		resultDiv.empty();
	}
	$.post(url, {searchStr: searchStr}, function(data){
		var resultTitel = $('<h2/>').text('Sökresultat');
		resultDiv.empty();
		resultDiv.append(resultTitel);
		console.debug(data);
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