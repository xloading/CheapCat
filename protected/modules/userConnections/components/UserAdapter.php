<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nayjest
 * Date: 18.08.11
 * Time: 17:56
 * To change this template use File | Settings | File Templates.
 */

class UserAdapter extends CApplicationComponent
{

    public $loginUrl = '/user/login';
    public $logoutUrl = '/user/logout';
	public $editProfileUrl = '/user/profile/edit';
    public $userModule;

    public function init()
    {
        $this->userModule = Yii::app()->getModule('user');
    }

    /**
     * @param $authService AbstractAuthService
     * @return User
     */
    public function registerUser($authService)
    {
        $data = $authService->userData;
        $user = new User();
        $user->setAttributes(
            array(
                 'status' => User::STATUS_ACTIVE,
                 'superuser' => 0,
                 'createtime' => time(),
                 'lastvisit' => time(),
                 'email' => isset($data['email'])?$data['email']:'',
                 'activkey' => UserModule::encrypting(microtime()),
                 'password' => '',
                 'username' => $authService->userId . get_class($authService),
            ),
            false
        );
        if (!$user->save(false)){
            throw new CException('Can\'t register user.');
        }
        $profile = new Profile();
        $profile->attributes = $data;
        $profile->validate();
        if ($profile->hasErrors()) {
            $errors = $profile->getErrors();
            foreach ($errors as $fieldName => $error) {
                if (isset($data[$fieldName])){
                    $profile[$fieldName] = null;
                }
            }
        }
        $profile->user_id = $user->primaryKey;

        if (!$profile->save(false)){
            $user->delete();
            throw new CException('Can\'t register user.');
        }
        return $user;
    }

    public function login($connection)
    {
        $userIdentity = new CUserIdentity($connection->user_id, '');
        Yii::app()->user->login($userIdentity, 3600 * 24 * 30); //@todo replace 3600*24*30 to some preconfigured value
    }
}
