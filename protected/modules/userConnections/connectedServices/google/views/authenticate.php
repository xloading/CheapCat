<?php
$service->registerScripts();
Yii::app()->getClientScript()->registerScript('google-auth', "
	$(document).ready(function() {
		google.load('gdata', '2.x', {packages:['gdata', 'contacts'], callback:function() {
			var hash = document.location.hash;
			if (google.accounts.user.checkLogin('$service->scopes')) {
				var token = google.accounts.user.login('$service->scopes');
				window.opener.finishGoogleAuthenticate(token);
				window.close();
				return;
			}
			if(hash.length > 2){
				google.accounts.user.logout();
			}
			google.accounts.user.login('$service->scopes');
		}});
	});
", CClientScript::POS_END);
?>
<img src="/images/google.jpg" style="display:none" alt="required for Google Data"/>