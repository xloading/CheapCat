<?php

class ServiceUserIdentity extends CUserIdentity
{

    private $_id;

    const ERROR_NOT_AUTHENTICATED = 3;

    /**
     * @var EAuthServiceBase the authorization service instance.
     */
    protected $service;

    /**
     * Constructor.
     * @param EAuthServiceBase $service the authorization service instance.
     */
    public function __construct($service)
    {
    $this->service = $service;
    }

    /**
     * Authenticates a user based on {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
    if ($this->service->isAuthenticated) {
        $userKey = md5($this->service->serviceName . $this->service->id);
        $user = FactoryService::get('user')->getBy('login = :login', array(':login' => $userKey));
        $data = new stdClass();
        if (!$user) {
        $data->login = $userKey;
        $data->password = md5(Yii::app()->params['pwdSalt'] . uniqid());
        $data->profile_name = $this->service->getAttribute('name');
        $data->register_date = date('Y-m-d H:i:s');
        $user = new UserModel($data);
        }
        $data->visit_date = date('Y-m-d H:i:s');
        $data->last_ip = Yii::app()->getRequest()->getUserHostAddress();
        $user->setDbData($data);
        if (FactoryService::get('user')->save($user)) {
        $this->_id = $user->getId();
        $this->username = $this->service->getAttribute('name');
        $this->setState('id', $this->_id);
        $this->setState('serviceId', $this->service->id);
        $this->setState('name', $this->username);
        $this->setState('service', $this->service->serviceName);
        $this->errorCode = self::ERROR_NONE;
        }
        else {
        $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
        }
    }
    else {
        $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
    }
    return !$this->errorCode;
    }

    public function getId()
    {
    return $this->_id;
    }

}
?>