<?php
/**
* @author Vitaliy Stepanenko <mail@vitaliy.in>
*/

class FacebookLogoutWidget extends CWidget{
	public $caption = '<img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">';
	public function run(){
		
	    $fb	= Yii::app()->socialNetworks->getPlugin('Facebook');
		$fb->registerScripts();									
		
		//if ($fb->getSocialNetworkUserId()){
			echo '<a href="'.$fb->fbApi->logoutUrl.'"><div id="fb-root"></div>'.$this->caption.'</a>';
		//}
		
	}
}