<?php

class AdminModule extends CWebModule
{
	public $defaultController = 'site';
        
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		$this->layoutPath = "protected/modules/admin/views/layouts";
		$this->layout = "/layouts/column1";
		
		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
?>