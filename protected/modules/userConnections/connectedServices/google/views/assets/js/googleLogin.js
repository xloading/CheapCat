function GoogleAuth() {
	var self = this;
	this.button = $('.google-auth-button');

	this.authenticate = function() {
		var url = "/userConnections/google/authenticate";
		var windowName = "Google Auth";
		var windowSize = "width=700,height=500";
		window.open(url, windowName, windowSize);
	}

	this.finishAuthenticate = function() {
		var dontRegister = this.button.data('dontregister');
		var callback = this.button.data('callback');
		var editProfileUrl = this.button.data('editprofileurl');
		$.ajax({
			url:"/userConnections/userConnection/login",
			data:{
				google: {
					token: self.token,
					dontRegister:dontRegister
				}
			},
			type:'post',
			dataType:'json',
			success:function(response) {
				self.button.hide();
				if (callback.length) {
					window[callback](self);
				} else if (response.status == 1 && response.data.isRegisteredUser) {
					window.location.href = editProfileUrl;
				} else {
					window.location.reload(true);
				}
			}
		});
	}
}
function finishGoogleAuthenticate(token) {
	var googleAuth = new GoogleAuth();
	googleAuth.token = token;
	googleAuth.finishAuthenticate();
}

$(document).ready(function() {
	var googleAuth = new GoogleAuth();
	googleAuth.authenticate();
});