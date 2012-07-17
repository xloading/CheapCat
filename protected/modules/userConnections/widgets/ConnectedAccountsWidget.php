<?php
class ConnectedAccountsWidget extends CWidget
{
	public function getModule()
	{
		return Yii::app()->getModule('userConnections');
	}

	public function run()
	{
		$this->getModule();
		$userServices = UserConnection::model()->forUser()->findAll();
		if (!empty($userServices)) {
			$this->render(
				'connectedAccounts'.DS.'list',
				array(
					'userServices' => $userServices
				));
		}
	}
}