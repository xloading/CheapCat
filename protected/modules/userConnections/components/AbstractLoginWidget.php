<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nayjest
 * Date: 16.08.11
 * Time: 18:37
 * To change this template use File | Settings | File Templates.
 */

abstract class AbstractLoginWidget extends CWidget
{
    public $assetsUrl;

    public $publishAssets = false;

    public $loggedInHtml = '';

    public function __construct($owner = null)
    {

        parent::__construct($owner);

        /*if ($this->publishAssets) {
            Yii::import('ext.filters.publishAssets.EPublishAssetsFilter');
            EPublishAssetsFilter::publish($this);
        }*/
    }

    /**
     * @return string
     */
    public function getServiceName()
    {
        $name = str_replace('LoginWidget', '', get_class($this));
        $name = strtolower($name[0]) . substr($name, 1);
        return $name;
    }

    /**
     * @return AbstractAuthService
     */
    public function getService()
    {
        return Yii::app()->getModule('userConnections')->getComponent($this->getServiceName());
    }
}
