<?php
/**********************************************************************************************
*                            CMS Open Real Estate
*                              -----------------
*	version				:	1.3.1
*	copyright			:	(c) 2012 Monoray
*	website				:	http://www.monoray.ru/
*	contact us			:	http://www.monoray.ru/contact
*
* This file is part of CMS Open Real Estate
*
* Open Real Estate is free software. This work is licensed under a GNU GPL.
* http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
* Open Real Estate is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
* Without even the implied warranty of  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
***********************************************************************************************/

require_once dirname(dirname(__FILE__)).'/services/VKontakteOAuthService.php';

class CustomVKService extends VKontakteOAuthService {	
	protected $jsArguments = array('popup' => array('width' => 750, 'height' => 450));
	protected $scope = 'users';
	protected $client_id = '';
	protected $client_secret = '';
	protected $providerOptions = array(
		'authorize' => 'http://oauth.vk.com/authorize',
		'access_token' => 'https://oauth.vk.com/access_token',
	);
	
	public function __construct() {
		$this->title = Yii::t('labels', 'Vkontakte');
	}
	
	protected function fetchAttributes() {
		$info = (array)$this->makeSignedRequest('https://api.vk.com/method/users.get', array(
			'query' => array(
				'uids' => $this->uid,
				'fields' => 'uid, first_name, contacts',
			),
		));

		$info = $info['response'][0];
		
		$this->attributes['id'] = $info->uid;
		$this->attributes['firstName'] = $info->first_name;
		$this->attributes['email'] = '';
		$this->attributes['mobilePhone'] = (isset($info->mobile_phone) && $info->mobile_phone) ? $info->mobile_phone : '';
		$this->attributes['homePhone'] = (isset($info->home_phone) && $info->home_phone) ? $info->home_phone : '';
		$this->attributes['url'] = 'http://vk.com/id'.$info->uid;
	}
}
