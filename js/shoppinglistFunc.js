recUti.shoppinglist = function(){
	var self = {
		add: function(){
			var recId = $(this).data('recipeid');
			var url = "api/index.php/?/json/shoppinglist/add";
			$.post(url, {recipe: recId}, function(data){
				if(data.success){
					var messagesDiv = $('#content .messages');
					messagesDiv.empty();
					messagesDiv.append('<p/>').text('Receptet är nu tillagt i inköpslistan!');
					// location.hash = '#shoppinglist';
				} else {
					var errors = data.errors;
					var errorDiv = $('#content .errors');
					errorDiv.empty();
					$.each(errors, function(index, value){
						errorDiv.append('<p>' + value + '</p>');
					});
				}
			},"json");
		},
		remove: function(){
			if(confirm("Är du säker på att du vill ta bort receptet från inköpslistan?")){
				var url = "api/index.php/?/json/shoppinglist/remove";
				var itemId = $(this).data('itemid');
				console.debug(itemId);
				console.debug(itemId.length);
				$.post(url, {itemId: itemId}, function(data){
					var renderContent = recUti.renderContent('shoppinglist');
					renderContent.shoppinglist();
				});
				return false;
			}
		}	
	};
	return self;
};