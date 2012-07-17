<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nayjest
 * Date: 17.08.11
 * Time: 16:47
 * To change this template use File | Settings | File Templates.
 */

/**
 * @property UserConnectionsModule $module
 */
class CombinedLoginWidget extends CWidget
{
	private $_options = array();

	public function __set($name, $value)
	{
		$this->_options[$name] = $value;
	}

	/**
	 * @return UserConnectionsModule
	 */
	public function getModule()
	{
		return Yii::app()->getModule('userConnections');
	}

	public function run()
	{
		$serviceConfigs = $this->module->services;
		echo $this->module->t('Login via:');
		foreach ($serviceConfigs as $name => $config) {
			$service = $this->module->getComponent($name);
			$this->widget($service->loginWidgetClass, $this->_options);
		}
	}
}
