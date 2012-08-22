<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';
	
	function filters() {
	    return array(
	        array(
	            'ESetReturnUrlFilter',
	            // Use for spcified actions (index and view):
	            // 'ESetReturnUrlFilter + index, view',
	        ),
	    );
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$service = Yii::app()->request->getQuery('service');

		if (Yii::app()->request->getQuery('soc_error_save'))
			Yii::app()->user->setFlash('error', tt('Error saving data. Please try again later.', 'socialauth'));
		if (Yii::app()->request->getQuery('deactivate'))
			showMessage(tc('Login'), tt('Your account not active. Administrator deactivate your account.', 'socialauth'), null, true);
		
		if (isset($service)) {
			$model = new Userlogin;

			$authIdentity = Yii::app()->eauth->getIdentity($service);
			$ret_url = Yii::app()->request->getQuery('ret');
			if(isset($ret_url) && $ret_url)
				Yii::app()->user->setReturnUrl($ret_url);
			$authIdentity->redirectUrl = Yii::app()->user->returnUrl;
			$authIdentity->cancelUrl = $this->createAbsoluteUrl('user/login');
			
			if ($authIdentity->authenticate()) {
				$identity = new EAuthUserIdentity($authIdentity);
								
				// успешная авторизация
				if ($identity->authenticate()) {
					//Yii::app()->user->login($identity);
					
					$uid = $identity->id;
					$firstName = $identity->firstName;
					$email = $identity->email;
					$service = $identity->serviceName;
					$mobilePhone = $identity->mobilePhone;
					$homePhone = $identity->homePhone;
					$isNewUser = false;
					
					$existId = User::getIdByUid($uid, $service);
					
					if (!$existId) {
						$isNewUser = true;
						$email = (!$email) ? User::getRandomEmail() : $email;
						$phone = '';
						if ($mobilePhone)
							$phone = $mobilePhone;
						elseif ($homePhone)
							$phone = $homePhone;
						
						$user = $this->createUser($email, $phone, '', true);	
						
						if (!$user && isset($user['id'])) {
							$authIdentity->redirect(Yii::app()->createAbsoluteUrl('/user/login').'?soc_error_save=1');
						}
						
						$success = User::setSocialUid($user['id'], $uid, $service);
						
						if (!$success) {
							User::model()->findByPk($user['id'])->delete();
							$authIdentity->redirect(Yii::app()->createAbsoluteUrl('/user/login').'?soc_error_save=1');
						}
						
						$existId = User::getIdByUid($uid, $service);
					}
					
					if ($existId) {	
						$result = $model->loginSocial($existId);
						if ($result){
	//						Yii::app()->user->clearState('id');
	//						Yii::app()->user->clearState('first_name');
	//						Yii::app()->user->clearState('nickname');
							if ($result === 'deactivate')
								$authIdentity->redirect(Yii::app()->createAbsoluteUrl('/user/login').'/deactivate/1');
							if ($isNewUser) 
								$authIdentity->redirect(Yii::app()->createAbsoluteUrl('/user/user/setemailandpass').'/service/'.$service/*.'/ret/'.Yii::app()->user->returnUrl*/);
							else
								$authIdentity->redirect(Yii::app()->createAbsoluteUrl('/usercpanel/main/index'));
						}
					}
					// специальное перенаправления для корректного закрытия всплывающего окна
					$authIdentity->redirect();
				}
				else {
					// закрытие всплывающего окна и перенаправление на cancelUrl
					$authIdentity->cancel();
				}
			}
			
			// авторизация не удалась, перенаправляем на страницу входа
			$this->redirect(array('error'));
		}
		
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
					if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}
	
	public function createUser($email, $phone = '', $activateKey = '', $isActive = false) {
		$model = new User;
		$model->email = $email;
		$model->username = $email;
		/*if ($phone)
			$model->phone = $phone;*/
		if ($isActive)
 			$model->status = 1;
		if ($activateKey)
 			$model->activkey = $activateKey;
		
		$password = $model->randomString();
		$model->setPassword($password);

		$return = array();
		
		if($model->save()){
			$return = array(
				'email' => $model->email,
				'username' => $model->username,
				'password' => $password,
				'id' => $model->id,
				'active' => $model->status,
				'activateKey' => $activateKey,
				'activateLink' => Yii::app()->createAbsoluteUrl('/site/activation', array('key' => $activateKey))
			);
		}
		else {
			var_dump($model->errors);
		}
		return $return;
	}
}