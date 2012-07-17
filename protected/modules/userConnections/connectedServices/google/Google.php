<?php
/**
 * @author Vitaliy Stepanenko <mail@vitaliy.in>
 */

class Google extends AbstractAuthService
{
	private $_userId;
	
	private $_profileUrl;

	private $_userData = array();

	private $zendInitialized = false;

	private $_token = null;

	public $js = 'https://www.google.com/jsapi';

	public $scopes = 'https://www.google.com/m8/feeds/ http://picasaweb.google.com/data/feed/';

	public function init()
	{
		Yii::import('application.modules.userConnections.connectedServices.google.models.*');
		parent::init();
	}

	public function initZend()
	{
		if (!$this->zendInitialized) {
			Yii::import('application.vendors.ZendFramework.library.*');
			require_once('Zend/Loader.php');
			Zend_Loader::loadClass('Zend_Gdata_AuthSub');
			Zend_Loader::loadClass('Zend_Gdata');
			Zend_Loader::loadClass('Zend_Gdata_Query');
		}
		$this->zendInitialized = true;
	}

	public function run()
	{
		$session = Yii::app()->session;
		if (isset($_POST['google'])) {
			$session['google'] = $_POST['google'];
		}
		if (isset($session['google']['dontRegister']) && $session['google']['dontRegister'] > 0) {
			return;
		}
		parent::run();
	}

	public function registerScripts()
	{
		Yii::app()->getClientScript()
			->registerCoreScript('jquery')
			->registerScriptFile($this->js, CClientScript::POS_END);
	}

	public function getUserId()
	{
		if (!$this->_userId) {
			$session = Yii::app()->session;
			if (isset($session['google']['id'])) {
				$this->_userId = $session['google']['id'];
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
			throw new CException('Cant get google token data.');
			return array();
		}

		$this->initZend();

		$query = new Zend_Gdata_Query('https://www.google.com/m8/feeds/contacts/default/full');
		$query->setMaxResults(1);

		$client = Zend_Gdata_AuthSub::getHttpClient($token);
		$gdata = new Zend_Gdata($client, Yii::app()->name);
		$gdata->setMajorProtocolVersion(3);

		try {
			$feed = $gdata->getFeed($query);
		} catch (Zend_Gdata_App_Exception $e) {
			Yii::trace("Get Google data: Request  failed. Server reply was {$e->getMessage()}.", 'warning');
			return array();
		}

		$author = $feed->getAuthor();
		$session = Yii::app()->session;
		$this->_userData = array(
			'firstName' => $author[0]->getName()->getText(),
			'email' => $session['google']['email']
		);
		return $this->_userData;
	}

	public function getToken()
	{
		if ($this->_token) {
			return $this->_token;
		}
		$session = Yii::app()->session;
		if (isset($session['google']['token'])) {
			$this->_token = $session['google']['token'];
		}
		return $this->_token;
	}

	public function fetchUserId()
	{
		$this->initZend();
		Zend_Loader::loadClass('Zend_Gdata_Photos');
		Zend_Loader::loadClass('Zend_Gdata_Photos_UserQuery');

		try {

			$query = new Zend_Gdata_Query('https://www.google.com/m8/feeds/contacts/default/full');
			$query->setMaxResults(1);

			$client = Zend_Gdata_AuthSub::getHttpClient($this->getToken());
			$gdata = new Zend_Gdata($client, Yii::app()->name);
			$gdata->setMajorProtocolVersion(3);

			$feed = $gdata->getFeed($query);
			$author = $feed->getAuthor();
			$userEmail = $author[0]->getEmail()->getText();

			$photos = new Zend_Gdata_Photos($client);
			$query = new Zend_Gdata_Photos_UserQuery();
			$query->setUser($userEmail);
			$query->setKind('album');
			$query->setAccess('all');
			$userFeed = $photos->getUserFeed(null, $query);
			$userId = $userFeed->getGphotoUser()->getText();

			$session = Yii::app()->session;
			$google = $session['google'];
			$google['id'] = $userId;
			$google['email'] = $userEmail;
			$session['google'] = $google;
			return $userId;
		} catch (Zend_Gdata_App_Exception $e) {
			Yii::trace("Get Google data: Request  failed. Server reply was {$e->getMessage()}.", 'warning');
			return null;
		}
	}

	public function getProfileUrl($id = null)
	{
		if($this->_profileUrl){
			return $this->_profileUrl;
		}
		$id = $id != null ? $id : $this->_userId;
		$this->_profileUrl = 'https://plus.google.com/'.$id;
		return $this->_profileUrl;
	}
}