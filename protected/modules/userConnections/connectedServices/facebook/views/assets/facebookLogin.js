function initFaceBook() {
	var self = this;
	this.$btnLogin = $('#fb-login');

	this.init = function() {
		if (typeof(FB) !== 'object') {
			return false;
		}
		$('<div id="fb-root"/>').appendTo('body');
		var params = {
			appId   : self.$btnLogin.data('appid'),
			session : self.$btnLogin.data('session'),
			status  : true, // check login status
			cookie  : true, // enable cookies to allow the server to access the session
			xfbml   : true // parse XFBML
		};
		FB.init(params);

		var e = self.$btnLogin;
		var editProfileUrl = e.data('url');
		var scope = e.data('scope');
		var callback = e.data('callback');
		var dontRegister = e.data('dontregister');
		var data = {
			facebookLoginData:{
				dontRegister:dontRegister
			}
		};
		FB.login(function (response) {
			if (response.session) {
				var access_token = response.session.access_token;
				$('#loading').show('slow');
				$.ajax({
					url:"/userConnections/userConnection/login",
					type:'post',
					data:data,
					dataType:'json',
					success:function(response) {
						self.$btnLogin.hide();
						if (callback.length) {
							window[callback](response);
						} else if (response.status == 1 && response.data.isRegisteredUser) {
							window.location.href = editProfileUrl;
						} else {
							window.location.reload(true);
						}
					}
				});
			}
		}, {scope: scope});
	}

	this.run = function() {
		if (typeof(FB) !== 'object') {
			$.ajax({
				url:self.$btnLogin.data('apiscript'),
				dataType:'script',
				success:self.init
			});
		} else {
			self.init();
		}
	}

	this.run();
}

$(document).ready(function() {
	new initFaceBook();
});