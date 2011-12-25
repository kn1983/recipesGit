window.recUtilities = {};
window.recUtilities.validateEmail = function validateEmail(email){
	var pattern = /^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/;
	if(email && email.match(pattern)){
		return true;
	} else {
		return false;
	}
};

//Signup user
window.recUtilities.submitUser = function submitUser(){
	var user = $('#regUser').val();
	var password = $('#regPassword').val();
	var email = $('#regEmail').val();
	var form = $('#signup');
	var url = "api/index.php?json/user/signup";
	var errorsDiv = $('#signup .errors');
	errorsDiv.empty();
	
	if(user!="" && user!="" && password!=""){
		$.post(url, form.serialize(), function(data){
			if(data.success == true){
				window.location = "index.php?page=regComplete";
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
	return false;
};

//Login user
window.recUtilities.loginUser = function loginUser(){
	var user = $('#user').val();
	var password = $('#password').val();
	var url = "api/index.php?json/user/login";
	
	if(user != "" && password != ""){
		$.post(url, {user: user, password: password}, function(data){
			if(data.success == true){
				window.location = "index.php";
			} else {
				alert(data.generalMessage);
			}
		},"json");
	} else {
		alert("Du måste ange användarnamn och lösenord!");
	}
	return false;
};

//Logut user 
window.recUtilities.logoutUser = function logoutUser(){
	var url = "api/index.php?json/user/logout";
	$.getJSON(url, function(data){
		window.location = "index.php";
	});
	return false;
};

$(function(){
	//Signup user
	$('#signupUser').click(window.recUtilities.submitUser);
	
	//Login user
	$('#login').click(window.recUtilities.loginUser);
	
	//Logout user
	$('#logout').click(window.recUtilities.logoutUser);
});
