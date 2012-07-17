<?php
$editProfileUrl = Yii::app()->getModule('userConnections')->userAdapter->editProfileUrl;
$callback = isset($callback) ? $callback : '';
$dontRegister = isset($dontRegister) ? (int)$dontRegister : 0;
$apiJsScript = $this->service->js;
$loginJsScript  = $this->assetsUrl . '/facebookLogin.js';

Yii::app()->clientScript
	->registerCoreScript('jquery')
	->registerScript('facebook-login-script', "
	$('#fb-login').click(function(){
		$.ajax({
			url:'$loginJsScript',
			dataType:'script'
		});
	});
	", CClientScript::POS_END);
?>
<button id="fb-login" class="login-button"
        data-appid='<?=$this->service->appId?>'
        data-url='<?=$editProfileUrl?>'
        data-session='<?=json_encode($this->service->fbApi->getSession())?>'
        data-scope='<?=$this->service->permissions?>'
        data-callback='<?=$callback?>'
        data-dontregister='<?=$dontRegister?>'
        data-apiscript='<?=$apiJsScript?>'
	>
	Facebook
</button>