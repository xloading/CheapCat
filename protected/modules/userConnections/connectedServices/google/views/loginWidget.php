<?php
$callback = isset($callback) ? $callback : '';
$dontRegister = isset($dontRegister) ? (int)$dontRegister : 0;
$editProfileUrl = Yii::app()->getModule('userConnections')->userAdapter->editProfileUrl;
$loginJsScript  = $this->assetsUrl . '/js/googleLogin.js';

Yii::app()->clientScript
	->registerScript('google-login-script', "
	$('.google-auth-button').click(function(){
		$.ajax({
			url:'$loginJsScript',
			dataType:'script'
		});
	});
	", CClientScript::POS_END);
?>
<button
	class="google-auth-button login-button"
	data-callback="<?=$callback?>"
	data-dontregister="<?=$dontRegister?>"
	data-editprofileurl="<?=$editProfileUrl?>"
    data-scopes="<?=$this->service->scopes?>"
	>Google
</button>
