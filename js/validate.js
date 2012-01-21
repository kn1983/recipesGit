recUti.validateEmail = function validateEmail(email){
	var pattern = /^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/;
	if(email && email.match(pattern)){
		return true;
	} else {
		return false;
	}
};