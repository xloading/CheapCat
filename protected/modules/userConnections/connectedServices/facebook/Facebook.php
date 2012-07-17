<?php
/**
 *
 * ===TODO:===
 * Logg of from facebook when registration finished
 * No email activation when registered with facebook
 * No password in registration form
 * Check posibility of default value null in profile field
 * @author Vitaliy Stepanenko <mail@vitaliy.in>
 */

class Facebook extends AbstractAuthService
{

	/**
	 * Facebook application Id  (OAuth client_id)
	 * must be configured
	 * @var string
	 */
	public $appId;

	private $_profileUrl;

	/**
	 * Facebook secret key (OAuth client_secret)
	 * must be configured
	 * @var string
	 */
	public $secret;

	public $permissions = 'user_birthday, user_photo_video_tags, friends_photo_video_tags, user_photos, friends_photos';

	public $useCookie = true;

	/**
	 * CURL options for using in Facebook-SDK class
	 *
	 * @var array
	 */
	public $curlOptions = array(

		CURLOPT_CONNECTTIMEOUT => 10,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 60,
		CURLOPT_USERAGENT => 'facebook-php-2.0',

		//CURLOPT_CAINFO => 'C:\xampp\htdocs\myFacebook\fb_ca_chain_bundle.crt',

		CURLOPT_SSL_VERIFYPEER => false, #remove this options on production server
		CURLOPT_SSL_VERIFYHOST => 2 #if it's no problems with SSL certificate

	);


	/**
	 * Facebook PHP-SDK class instance
	 * @var FacebookApi
	 */
	private $_fbApi;

	/**
	 * Facebook user id
	 * @var string | null
	 */
	private $_userId;

	/**
	 * Facebook user data
	 * @var array
	 */
	private $_userData;

	public $js = 'http://connect.facebook.net/en_US/all.js';


	/**
	 *
	 * @return FacebookApi
	 */
	public function getFbApi()
	{
		if ($this->_fbApi) {
			return $this->_fbApi;
		} else {
			if (!$this->appId or !$this->secret) {
				throw new CException('Facebook appId and secret key isn\'t specified');
			} else {
				#creating new Facebook PHP-SDK class instance
				$this->_fbApi = new FacebookApi(array(
				                                     'appId' => $this->appId,
				                                     'secret' => $this->secret,
				                                     'cookie' => $this->useCookie,
				                                ));
				FacebookApi::$CURL_OPTS = $this->curlOptions;
				return $this->_fbApi;
			}
		}
	}

	/**
	 * Get user id from facebook
	 * @return string | null
	 */
	public function getUserId()
	{
		if (!$this->_userId) {
			$session = $this->fbApi->getSession();
			if ($session) {
				try {
					$this->_userId = $this->fbApi->getUser();
				} catch (FacebookApiException $e) {
					$this->_userId = null;
					//error_log($e);
				}
			} else { #we have no facebook session
				$this->_userId = null;
			}
		}
		return $this->_userId;
	}


	public function getUserData($id = null)
	{
		if (!$id) {
			$id = $this->userId;
		}
		if (!$this->_userData) {
			$session = $this->fbApi->getSession();
			if ($session) {
				try {
					//Здесь можно подтянуть также все необходимые данные с фейсбука и сохранить их в $this->_userData
					$data = $this->fbApi->api('/me');
					if (!$this->_userId) $this->_userId = $this->_userData['id'];
					$data['avatar'] = 'https://graph.facebook.com/' . $this->_userId . '/picture';
					$this->_userData = $this->convertUserData($data);
				} catch (FacebookApiException $e) {
					error_log($e);
					$this->_userData = array();
				}
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
			'nickname' => 'username', //@todo
			'avatar' => 'avatar'
		);

		$res = array();
		foreach ($fieldNames as $k => $v) {
			if (isset($data[$v])) {
				$res[$k] = $data[$v];
			}
		}


		if (isset($data['gender'])) {
			if ($data['gender'] == 'male') {
				$res['gender'] = 1;
			} else if ($data['gender'] == 'female') {
				$res['gender'] = 2;
			}
		}

		if (isset($data['birthday'])) {
			$res['birthdate'] = date('Y-m-d', strtotime($data['birthday']));
		}
		return $res;
	}

	public function run()
	{
		$session = Yii::app()->session;
		if (isset($_POST['facebookLoginData'])) {
			$session['facebook'] = $_POST['facebookLoginData'];
		}
		if (isset($session['facebook']['dontRegister']) && $session['facebook']['dontRegister'] > 0) {
			return;
		}
		parent::run();
	}

	public function getProfileUrl($id = null)
	{
		if ($this->_profileUrl) {
			return $this->_profileUrl;
		}
		$id = $id != null ? $id : $this->_userId;
		$this->_profileUrl = 'http://www.facebook.com/profile.php?id=' . $id;
		return $this->_profileUrl;
	}
}