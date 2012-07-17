<?php
$editProfileUrl = Yii::app()->getModule('userConnections')->userAdapter->editProfileUrl;
$callback = isset($callback) ? $callback : '';
$dontRegister = isset($dontRegister) ? (int)$dontRegister : 0;

$apiJsScript = $this->service->js;
$loginJsScript  = $this->assetsUrl . '/vkontakteLogin.js';

Yii::app()->clientScript
	->registerCoreScript('jquery')
	->registerScript('vkontakte-login-script', "
	$('#vk-login').click(function(){
		$.ajax({
			url:'$loginJsScript',
			dataType:'script'
		});
	});
	", CClientScript::POS_END);
?>

<button
	id="vk-login"
	class="login-button"
	data-permissions="<?php echo $this->service->permissions?>"
	data-appid="<?php echo $this->service->appId?>"
	data-url="<?=$editProfileUrl?>"
	data-callback='<?=$callback?>'
	data-dontregister='<?=$dontRegister?>'
    data-apiscript='<?=$apiJsScript?>'
	>
	Вконтакте
</button>