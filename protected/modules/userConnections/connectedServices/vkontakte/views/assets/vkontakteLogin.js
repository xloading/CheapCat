function initVkontakte() {
	var self = this;
	this.$btnLogin = $('#vk-login');

	this.vkLoginCallback = function(vkResponse) {
		if (vkResponse.session && vkResponse.session.user) {
			$('#loading').show('slow');
			var editProfileUrl = self.$btnLogin.data('url');
			var callback = self.$btnLogin.data('callback');
			var dontRegister = self.$btnLogin.data('dontregister')
			var data = {};
			data['vkLoginData'] = vkResponse;
			data['vkLoginData']['dontRegister'] = dontRegister;
			$.ajax({
				url:"/userConnections/userConnection/login",
				data:data,
				type:'post',
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
	}

	this.init = function() {
		if (typeof(VK) !== 'object') {
			return false;
		}
		VK.init({apiId: self.$btnLogin.data('appid')});
		VK.Auth.getLoginStatus(self.vkLoginCallback);
		permissions = $(this).data('permissions');
		VK.Auth.login(self.vkLoginCallback, permissions);
	}

	this.run = function() {
		if (typeof(VK) !== 'object') {
			$.ajax({
				url:self.$btnLogin.data('apiscript'),
				dataType:'script',
				success:self.init
			});
		} else {
			this.init();
		}
	}

	this.run();
}

$(document).ready(function() {
	new initVkontakte();
});