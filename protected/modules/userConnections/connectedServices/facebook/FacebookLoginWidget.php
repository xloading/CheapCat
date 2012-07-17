<?php
/**
 * @author Vitaliy Stepanenko <mail@vitaliy.in>
 */

class FacebookLoginWidget extends AbstractLoginWidget
{

	public $publishAssets = true;

	public $loggedInHtml = '<div id="fb-root" style="display: none;"></div>';

	public $options;

	public function run()
	{
		if (!$this->service->isAuthenticated or Yii::app()->user->isGuest or !$this->service->isRegistered($this->service->userId)) {
			if (!isset($this->options['callback']) && isset($_GET['cb'])) {
				$this->options['callback'] = $_GET['cb'];
			}
			$this->render('loginWidget', $this->options);
		}

	}
}