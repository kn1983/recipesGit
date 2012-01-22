recUti.validate = function(form){
	var self = {
		isValid: true,
		email: function(email){
			var pattern = /^[\_]*([a-z0-9]+(\.|\_*)?)+@([a-z][a-z0-9\-]+(\.|\-*\.))+[a-z]{2,6}$/;
			if(email.match(pattern)){
				return true;
			} else {
				self.isValid = false;
				return false;
			}
		},
		digt: function(str){
			var pattern = /^\d*$/;
			if(str.match(pattern)){
				return true;
			} else {
				self.isValid = false;
				return false;
			}
		},
		form: function(){
			var formEls = form.find('input, select, textarea');
			formEls.each(function(index, value){
				var formEl = $(value);
				var formElVal = formEl.val();
				if(formElVal == ""){
					formEl.addClass('error');
					self.isValid = false;
				}
				if(formEl.attr('type') == 'number'){
					if(!self.digt(formElVal)){
						formEl.addClass('error');
					}
				}	
				if(formEl.attr('type') == 'email'){
					if(!self.email(formElVal)){
						formEl.addClass('error');		
					}
				}
			});
		},
		removeError: function(){
			var el = $(this);
			if(el.hasClass('error')){
				el.removeClass('error');
			}
		}
	};	
	return self;
};