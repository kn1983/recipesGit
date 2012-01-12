// recUti = {};
recUti.user = function(){
	var ret = {
		submit: function(){
			var user = $('#regUser').val();
			var password = $('#regPassword').val();
			var email = $('#regEmail').val();
			var form = $('#signup');
			var url = "api/index.php?json/user/signup";
			var errorsDiv = $('#signup .errors');
			errorsDiv.empty();
			
			if(user!="" && user!="" && password!=""){
				$.post(url, form.serialize(), function(data){
					var content = $('.signup #content');
					if(data.success == true){
						content.empty();
						content.append('<p>').text('Tack för din registrering! Du är nu välkommen att logga in.');
					} else {
						var errors = data.errors;
						for(var i = 0; i < errors.length; i++){
							errorsDiv.append('<p>' + errors[i] + '</p>');
						}
					}
				},"json");
			} else {
				errorsDiv.append('<p>Du måste fylla i alla fält</p>');
			}
		},
		submitBtn: $('#signupUser').bind("click", function(event){
			ret.submit();
			return false;
		}),
		login: function(){
			var user = $('#user').val();
			var password = $('#password').val();
			var url = "api/index.php?json/user/login";
			
			if(user != "" && password != ""){
				$.post(url, {user: user, password: password}, function(data){
					if(data.success == true){
						location = "index.php";
					} else {
						alert(data.generalMessage);
					}
				},"json");
			} else {
				alert("Du måste ange användarnamn och lösenord!");
			}
			return false;	
		},
		loginBtn: $('#login').bind("click", function(event){
			ret.login();
		}),
		logout: function(){
			var url = "api/index.php?json/user/logout";
			$.getJSON(url, function(data){
				location = "index.php";
			});
		},
		logoutBtn: $('#logout').bind("click", function(event){
			ret.logout();
		})
	};
	return ret;	
};

recUti.validateEmail = function validateEmail(email){
	var pattern = /^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/;
	if(email && email.match(pattern)){
		return true;
	} else {
		return false;
	}
};

$(function(){
	var user = recUti.user();
});
