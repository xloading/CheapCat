<?php
/**
 * @author Vitaliy Stepanenko <mail@vitaliy.in>
 */

class VkontakteLoginWidget extends AbstractLoginWidget
{

    public $publishAssets = true;

    public $loggedInHtml = 'VK: you logged in';

	public $options;

    public function run()
    {
        if (!$this->service->isAuthenticated) {
	        if (!isset($this->options['callback']) && isset($_GET['cb'])) {
				$this->options['callback'] = $_GET['cb'];
			}
			$this->render('loginWidget', $this->options);
        }
    }
}