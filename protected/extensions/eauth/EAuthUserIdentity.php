<?php
/**
 * EAuthUserIdentity class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * EAuthUserIdentity is a base User Identity class to authenticate with EAuth.
 * @package application.extensions.eauth
 */
class EAuthUserIdentity extends CBaseUserIdentity {
	const ERROR_NOT_AUTHENTICATED = 3;

	/**
	 * @var EAuthServiceBase the authorization service instance.
	 */
	protected $service;
	
	/**
	 * @var string the unique identifier for the identity.
	 */
	protected $id;
	
	/**
	 * @var string the display name for the identity.
	 */
	protected $name;
	
	/**
	 * Constructor.
	 * @param EAuthServiceBase $service the authorization service instance.
	 */
	public function __construct($service) {
		$this->service = $service;
	}
	
	/**
	 * Authenticates a user based on {@link service}.
	 * This method is required by {@link IUserIdentity}.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {		
		if ($this->service->isAuthenticated) {
			$this->id = $this->service->id;
			$this->name = $this->service->getAttribute('name');
			
			$user = User::model()->findByAttributes(array('identity' => $this->id, 'service' => $this->service->serviceName));
			if (!$user) {
				$user = new User();
				$user->username = md5($this->service->serviceName . $this->service->id);
				$user->password = md5(Yii::app()->params['passwordSalt'] . uniqid());
				$user->profile_name = $this->service->getAttribute('name');
				$user->activkey=UserModule::encrypting(microtime().$model->password);
				$user->createtime=time();
				$user->lastvisit=((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin)?time():0;
				$user->superuser=0;
				$user->status=1;
				
				$user->service = $this->service->serviceName;
				$user->identity = $this->id;
			}
			
			if ($user->save())	{
				$identity=new UserIdentity($model->username,$soucePassword);
				$identity->authenticate();
				Yii::app()->user->login($identity,0);
				$this->redirect(Yii::app()->controller->module->returnUrl);
			}
			$this->setState('id', $this->id);
			$this->setState('name', $this->name);
			$this->setState('service', $this->service->serviceName);
			
			$this->errorCode = self::ERROR_NONE;		
		}
		else {
			$this->errorCode = self::ERROR_NOT_AUTHENTICATED;
		}
		return !$this->errorCode;
	}

	/**
	 * Returns the unique identifier for the identity.
	 * This method is required by {@link IUserIdentity}.
	 * @return string the unique identifier for the identity.
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Returns the display name for the identity.
	 * This method is required by {@link IUserIdentity}.
	 * @return string the display name for the identity.
	 */
	public function getName() {
		return $this->name;
	}
}