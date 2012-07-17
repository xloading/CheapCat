<?php
$callback = isset($callback) ? $callback : '';
$dontRegister = isset($dontRegister) ? (int)$dontRegister : 0;
$editProfileUrl = Yii::app()->getModule('userConnections')->userAdapter->editProfileUrl;
$loginJsScript  = $this->assetsUrl . '/js/flickrLogin.js';

Yii::app()->clientScript
	->registerCoreScript('cookie')
	->registerScript('flickr-login-script', "
	$('.flickr-auth-button').click(function(){
		$.ajax({
			url:'$loginJsScript',
			dataType:'script'
		});
	});
	", CClientScript::POS_END)
?>
<button
	class="flickr-auth-button login-button"
	data-callback="<?=$callback?>"
	data-dontregister="<?=$dontRegister?>"
	data-editprofileurl="<?=$editProfileUrl?>"
	>Flickr
</button>
