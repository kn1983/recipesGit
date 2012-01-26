recUti.user = function(){
	var self = {
		signup: function(){
			var form = $('#signupForm');
			var url = "api/index.php?json/user/signup";
			var validate = recUti.validate(form);
			validate.form();
			if(validate.isValid){
				$.post(url, form.serialize(), function(data){
					var content = $('#content');
					if(data.success == true){
						content.empty();
						content.append('<p>').text('Tack för din registrering! Du är nu välkommen att logga in.');
					} else {
						var errors = data.errors;
						var errorDiv = form.find('.errors');
						errorDiv.empty();
						$.each(errors, function(index, value){
							var error = $('<p/>').text(value);
							errorDiv.append(error);
						});
					}
				},"json");
			}
			return false;
		},
		login: function(){
			var form = $('#loginForm');
			var url = "api/index.php?json/user/login";
			var user = $('#user').val();
			var password = $('#password').val();
			var validate = recUti.validate(form);
			validate.form();
			if(validate.isValid){
				$.post(url, form.serialize(), function(data){
					if(data.success == true){
						location = "index.html";
					} else {
						alert(data.errors[0]);
					}
				},"json");
			}
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