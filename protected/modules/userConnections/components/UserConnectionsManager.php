<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nayjest
 * Date: 18.08.11
 * Time: 15:59
 * To change this template use File | Settings | File Templates.
 */

class UserConnectionsManager extends CApplicationComponent
{
    public $services;

    public function getModule()
    {
        return Yii::app()->getModule('userConnections');
    }

    public function init()
    {

        $this->services = $this->module->services;
        foreach ($this->services as $name => $config) {
            /** @var $service AbstractAuthService */
            $service = $this->services[$name] = $this->module->getComponent($name);
            $service->run();
        }
        parent::init();

    }

}
