function FlickrAuth() {
	var self = this;
	this.button = $('.flickr-auth-button');

	this.authenticate = function() {
		var token = $.cookie('flickr-token');
		if (token && token.length) {
			this.token = token;
			return this.finishAuthenticate();
		}
		var url = "/userConnections/flickr/authenticate";
		var windowName = "Flickr Auth";
		var windowSize = "width=700,height=500";
		window.open(url, windowName, windowSize);
	}

	this.finishAuthenticate = function()
	{
		var dontRegister = this.button.data('dontregister');
		var callback = this.button.data('callback');
		var editProfileUrl = this.button.data('editprofileurl');
		$.ajax({
			url:"/userConnections/userConnection/login",
			data:{
				flickr: {
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
				}else if(response.status == 1 && response.data.isRegisteredUser) {
					window.location.href = editProfileUrl;
				}else{
					window.location.reload(true);
				}
			}
		});
	}
}
function finishFlickrAuthenticate(token) {
	var flickrAuth = new FlickrAuth();
	flickrAuth.token = token;
	flickrAuth.finishAuthenticate();
}
$(document).ready(function(){
	var flickrAuth = new FlickrAuth();
	flickrAuth.authenticate();
});