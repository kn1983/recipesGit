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
	
	if(window.recUtilities.validateEmail(email) && user!="" && password!=""){
		$.post(url, form.serialize(), function(data){
			if(data.success == true){
				window.location = "index.php?page=regComplete";
			} else {
				alert(data.msg);
			}
		},"json");
	} else {
		alert("Fel användarnamn eller lösenord");
	}
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
				alert(data.msg);
			}
		},"json");
	} else {
		alert("Fel användarnamn eller lösenord");
	}
};

//Logut user 
window.recUtilities.logoutUser = function logoutUser(){
	var url = "api/index.php?json/user/logout";
	$.getJSON(url, function(data){
		window.location = "index.php";
	});
};

$(function(){
	//Signup user
	$('#signupUser').click(function(){
		window.recUtilities.submitUser();
		return false;
	});
	
	//Login user
	$('#login').click(function(){
		window.recUtilities.loginUser();
		return false;
	});
	
	//Logout user
	$('#logout').click(function(){
		window.recUtilities.logoutUser();
	});
});