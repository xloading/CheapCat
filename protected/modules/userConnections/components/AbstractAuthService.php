<?php
/**
 *
 * @author Vitaliy Stepanenko <mail@vitaliy.in>
 * @package userConnections
 * @license BSD
 * @version $Id:$
 */


/**
 * Base class for component of UserConnectionsModule that implement authentication via 3rd-party service.
 *
 * @property string|null $userId
 * @property string loginWidgetClass
 * @property string logoutWidgetClass
 * @property UserConnection|null $model
 * @property bool $isAuthenticated
 * @property bool $isRegistered
 * @property array $userData
 * @property UserConnectionsModule $module
 */
abstract class AbstractAuthService extends CApplicationComponent
{

	/**
	 * User states
	 */
	const STATE_GUEST = 0;
	const STATE_NEW = 2;
	const STATE_NEED_SITE_AUTH = 3;
	const STATE_HAVE_NO_CONNECTIONS = 4;
	const STATE_NEED_SERVICE_AUTH = 5;
	const STATE_NEED_CONNECTION = 6;
	const STATE_READY = 7;

	public $registeredUser = false;

	/**
	 * @return bool
	 */
	final public function getUserState()
	{
		return !Yii::app()->user->isGuest * 4 + $this->isAuthenticated * 2 + $this->isRegistered;
	}

	/**
	 * @abstract
	 * @return string|null user id in auth service
	 */
	abstract public function getUserId();

	/**
	 * @return string
	 */
	public function getLoginWidgetClass()
	{
		return get_class($this) . 'LoginWidget';
	}

	/**
	 * @return string
	 */
	public function getLogoutWidgetClass()
	{
		return get_class($this) . 'LogoutWidget';
	}

	/**
	 * @return UserConnectionsModule
	 */
	final public function getModule()
	{
		return Yii::app()->getModule('userConnections');
	}

	/**
	 * @param string|null $id User id in auth service. Current authenticated user id is used when null passed as $id
	 * @return UserConnection|null Model for currently logged in to auth service account or account with specified service user id
	 */
	final public function getModel($id = null)
	{

		if (!$id) {
			if (!$this->isAuthenticated) return null;
			$id = $this->userId;
		}

		return UserConnection::model()->findByAttributes(
			array(
			     'service_user_id' => $this->userId,
			     'name' => get_class($this)
			)
		);
	}

	/**
	 * @return bool True if user is authenticated in 3-rd party auth service (not in current site!)
	 */
	public function getIsAuthenticated()
	{
		return $this->userId != null;
	}

	/**
	 * @param string|null $id User id in auth service. Current authenticated user id is used when null passed as $id
	 * @return bool True if db record for
	 */
	public function getIsRegistered($id = null)
	{
		return (boolean)$this->getModel($id);
	}

	/**
	 * @param integer $userId  User id on current site
	 * @return  UserConnection
	 */
	final public function connectUser($userId)
	{
		$userId or $userId = Yii::app()->user->id;
		$connection = new UserConnection();
		$connection->attributes = array(
			'user_id' => $userId,
			'name' => get_class($this),
			'service_user_id' => $this->userId
		);
		$connection->save();
		return $connection;
	}

	/**
	 * @abstract
	 * @param string|null $id User id in auth service. Use current authenticated user id is used when null passed as $id
	 * @return void
	 */
	abstract public function getUserData($id = null);

	/**
	 * This method is called by UserConnectionsManager, that must be registered in preload.
	 * Don't call it manually.
	 * @return null
	 */
	public function run()
	{
		$state = $this->userState;
		switch ($state) {
			case self::STATE_GUEST:
				return;
			case self::STATE_NEW:
				$user = $this->module->userAdapter->registerUser($this);
				$connection = $this->connectUser($user->primaryKey);
				$this->module->userAdapter->login($connection);
				$this->registeredUser = true;
				return;

			case self::STATE_NEED_SITE_AUTH:
				//$this->module->userAdapter->authenticate($this->model);
				return;

			case self::STATE_HAVE_NO_CONNECTIONS;
				return;

			case self::STATE_NEED_CONNECTION:
				$this->connectUser(UserModule::user()->id);
				return;

			case self::STATE_NEED_SERVICE_AUTH:
				//@todo
				return;

			case self::STATE_READY:
				return;

		}
	}
}
