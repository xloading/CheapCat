<?php
/**
 * @author Vitaliy Stepanenko <mail@vitaliy.in>
 */

class Vkontakte extends AbstractAuthService
{

	private $_api;

	private $_profileUrl;

	/**
	 * Social Network user id
	 * @var Facebook
	 */
	private $_userId;

	/**
	 * Social Network user data
	 * @var Facebook
	 */
	private $_userData;


	/**
	 * Vkontakte application Id
	 * must be configured
	 * @var string
	 */
	public $appId;

	/**
	 * Vkontakte secret key
	 * must be configured
	 * @var string
	 */
	public $secret;

	public $permissions = 5;

	public $js = 'http://vkontakte.ru/js/api/openapi.js';


	/**
	 *
	 * @return object
	 */
	public function getApi()
	{
		if ($this->_api) {
			return $this->_api;
		} else {
			if (!$this->appId or !$this->secret) {
				throw new CException('Social network appId and secret key isn\'t specified');
			} else {
				$this->_api = new VkontakteApi($this->appId, $this->secret);
				return $this->_api;
			}
		}
	}


	public function registerScripts()
	{
		// Yii::app()->getClientScript()
		// ->registerScriptFile('http://vkontakte.ru/js/api/openapi.js');
		//->registerScriptFile('vk.JS', 'VK.init({apiId: "' . $this->appId . '"});', CClientScript::POS_END);
	}


	public function run()
	{
		$session = Yii::app()->session;
		if (isset($_POST['vkLoginData'])) {
			/** @var CHttpSession */
			$session['vk'] = $_POST['vkLoginData'];
			//$this->isAjaxRequest = true;
		}
		if (isset($session['vk']['dontRegister']) && $session['vk']['dontRegister'] > 0) {
			return;
		}
		parent::run();
		//		if ($this->isAjaxRequest) {
		//			die('/user/profile');/** @todo WTF??? */
		//		}
	}

	public function getUserId()
	{
		/** @var CHttpSession $session */
		$session = Yii::app()->session;

		if (
			isset($session['vk']) and
			isset($session['vk']['session']) and
			isset($session['vk']['session']['user'])
		) {
			return $session['vk']['session']['user']['id'];
		}
	}

	public function getUserData($id = null)
	{

		if (!$id) {
			$id = $this->userId;
		}

		if (!$this->_userData) {
			$res = $this->getApi()->api('getProfiles', array('uids' => $id, 'fields' => 'uid, first_name, last_name, nickname, screen_name, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, has_mobile, rate, contacts, education, online'));

			if (isset($res['response']) and is_array($res['response']) and isset($res['response'][0])) {
				$this->_userData = $this->convertUserData($res['response'][0]);
			} else {
				$this->_userData = array();
			}

		}
		return $this->_userData;

	}

	private function convertUserData($data)
	{


		$fieldNames = array(
			'firstName' => 'first_name',
			'lastName' => 'last_name',
			//'birthDate' => 'bdate',
			'nickname' => 'nickname',
			'phoneHome' => 'home_phone',
			'phoneMobile' => 'mobile_phone',
			'avatar' => 'photo'
		);

		$res = array();
		foreach ($fieldNames as $k => $v) {
			if (isset($data[$v])) {
				$res[$k] = $data[$v];
			}
		}

		if (isset($res['phoneMobile'])) {
			$res['phone'] = $res['phoneMobile'];
		} elseif (isset($res['phoneHome'])) {
			$res['phone'] = $res['phoneHome'];
		}

		if (isset($data['sex'])) {
			if ($data['sex'] == '2') {
				$res['gender'] = 1;
			} else if ($data['sex'] == '3') {
				$res['gender'] = 2;
			}
		}

		if (isset($data['bdate'])) {
			$res['birthdate'] = date('Y-m-d', strtotime($data['bdate']));
		}


		return $res;
	}

	public function getProfileUrl($id = null)
	{
		if ($this->_profileUrl) {
			return $this->_profileUrl;
		}
		$id = $id != null ? $id : $this->_userId;
		$this->_profileUrl = 'http://vkontakte.ru/?id=' . $id;
		return $this->_profileUrl;
	}
}