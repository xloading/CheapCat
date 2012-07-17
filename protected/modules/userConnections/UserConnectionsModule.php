<?php

class UserConnectionsModule extends CWebModule
{
	public $defaultController = 'userConnection';

	public $controllerMap = array(
		'google' => 'application.modules.userConnections.connectedServices.google.controllers.GoogleController',
		'flickr' => 'application.modules.userConnections.connectedServices.flickr.controllers.FlickrController'
	);

	private $_assetsUrl;

	private $_serviceComponents = null;

	/**
	 * @var array connected services configuration
	 */
	public $services = array();

	public $userAdapter = array(
		'class' => 'userConnections.components.UserAdapter',
		'loginUrl' => '/user/login',
		'logoutUrl' => '/user/logout',
	);

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(
			array(
			     'userConnections.models.*',
			     'userConnections.components.*'
			)
		);
		foreach ($this->services as $name => &$config) {
			$partOfName = substr($name, 1);
			$id = strtolower($name[0]) . $partOfName;
			$class = strtoupper($name[0]) . $partOfName;
			$config['class'] = "userConnections.connectedServices.{$id}.{$class}";
			Yii::import("userConnections.connectedServices.{$id}.*");
		}
		$this->setComponents(CMap::mergeArray($this->services, array('userAdapter' => $this->userAdapter)));
		$this->userAdapter = $this->getComponent('userAdapter');
	}

	public function getAssetsUrl()
	{
		if ($this->_assetsUrl === null) {
			$assetsPath = Yii::getPathOfAlias('userConnections.views.assets');
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish($assetsPath, false, -1, YII_DEBUG);
		}
		return $this->_assetsUrl;
	}

	public function getServiceComponents()
	{
		$serviceComponents = array();
		foreach ($this->services as $name => $config) {
			$serviceComponents[] = $this->module->getComponent($name);
		}
	}

	/**
	 * @param string $message the original message
	 * @param array $params parameters to be applied to the message using <code>strtr</code>.
	 * @param string $dictionary Name of file with translation : <moduleDir>/messages/<$dictionary>.php)
	 * @return string the translated message
	 */
	public function t($message, $params = array(), $dictionary = 'translation')
	{
		return Yii::t(get_class($this) . '.' . $dictionary, $message, $params);
	}

}
