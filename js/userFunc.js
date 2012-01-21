recUti.user = function(){
	var self = {
		submit: function(){
			var form = $('#signupForm');
			var url = "api/index.php?json/user/signup";
			$.post(url, form.serialize(), function(data){
				var content = $('#content');
				if(data.success == true){
					content.empty();
					content.append('<p>').text('Tack för din registrering! Du är nu välkommen att logga in.');
				} else {
					console.debug("error");
				}
			},"json");
			return false;
		},
		login: function(){
			var form = $('#loginForm');
			var url = "api/index.php?json/user/login";
			
			$.post(url, form.serialize(), function(data){
				if(data.success == true){
					location = "index.html";
				} else {
					alert(data.generalMessage);
				}
			},"json");
			return false;	
		},
		logout: function(){
			var url = "api/index.php?json/user/logout";
			$.getJSON(url, function(data){
				location = "index.html";
			});
		}
	};
	return self;	
};