recUti.dialog = function(dialog){
	var dialogBg = $('.dialogBg');
	var self = {
		status: "CLOSED",
		closeBtn: $('.dialog .close').bind("click", function(event){
			self.close();
			return false;
		}),
		open: function(){
			dialogBg.removeClass('hidden');
			dialog.removeClass('hidden');
			self.status = "OPEN";
		},
		close: function(){
			dialogBg.addClass('hidden');
			dialog.addClass('hidden');
			self.status = "CLOSED";
		}	
	}
	return self;
};