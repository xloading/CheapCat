<?php
class Flickr extends AbstractAuthService
{
	private $_userId;

	public $key;

	public $secret;

	private $_apiInitialized;

	private $_userData = array();

	private $_token = null;

	public $scope = 'read';

	protected $_api;

	private $_profileUrl;

	public function run()
	{
		$session = Yii::app()->session;
		if (isset($_POST['flickr'])) {
			$session['flickr'] = $_POST['flickr'];
		}
		if (isset($session['flickr']['dontRegister']) && $session['flickr']['dontRegister'] > 0) {
			return;
		}
		parent::run();
	}

	public function authenticate()
	{
		if (!isset($_GET['frob'])) {
			$frob = $this->api->requestFrob();
			$url = $this->api->buildAuthUrl($this->scope, $frob);
			Yii::app()->request->redirect($url);
		}
		$token = $this->api->setAuthTokenFromFrob($_GET['frob']);
		$this->_token = $token;
		setcookie("flickr-token", $token, time() + (60 * 60 * 24 * 365));
		return true;
	}

	public function getUserId()
	{
		if (!$this->_userId) {
			$session = Yii::app()->session;
			if (isset($session['flickr']['id'])) {
				$this->_userId = $session['flickr']['id'];
			} elseif ($this->getToken()) {
				$this->_userId = $this->fetchUserId();
			}
		}
		return $this->_userId;
	}

	public function getUserData($id = null)
	{
		if ($id !== null and $id != $this->_userId) {
			throw new CException('Current implementation of Google auth. service not supports getting profiles of users that differs from currently authenticated.');
			return array();
		}

		if ($this->_userData) {
			return $this->_userData;
		}

		if (!$token = $this->getToken()) {
			throw new CException('Cant get flickr token data.');
			return array();
		}

		$request = $this->api->createRequest('flickr.people.getInfo', array('user_id' => $this->getUserId()));
		$response = $request->execute();
		if (!is_object($response)) {
			throw new CException('Cant make flickr data request.');
			return array();
		}
		$this->_userData = array(
			'firstName' => $response->xml->person->username->__toString(),
		);
		return $this->_userData;
	}

	public function getToken()
	{
		if ($this->_token) {
			return $this->_token;
		}
		$session = Yii::app()->session;
		if (isset($session['flickr']['token'])) {
			$this->_token = $session['flickr']['token'];
		}
		return $this->_token;
	}

	public function fetchUserId()
	{
		$userId = $this->api->getUserId();
		$session = Yii::app()->session;
		$flickr = $session['flickr'];
		$flickr['id'] = $userId;
		$session['flickr'] = $flickr;
		return $userId;
	}

	public function getApi()
	{
		if ($this->_api) {
			return $this->_api;
		}
		if (!$this->_apiInitialized) {
			Yii::import('application.vendors.Phlickr.*');
			require_once('Phlickr/Api.php');
			$this->_apiInitialized = true;
		}
		$this->_api = new Phlickr_Api($this->key, $this->secret);
		if (!$this->_api->getAuthToken() && ($token = $this->getToken())) {
			$this->_api->setAuthToken($token);
		}
		return $this->_api;
	}

	public function getProfileUrl($id = null)
	{
		if ($this->_profileUrl) {
			return $this->_profileUrl;
		}
		$id = $id != null ? $id : $this->_userId;
		$this->_profileUrl = 'http://www.flickr.com/photos/' . $id;
		return $this->_profileUrl;
	}
}