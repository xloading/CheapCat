<?php

class SiteController extends Controller
{
	private $_model;
	public $modelName;
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	
	public function actionProducts()
	{
		// renders the view file 'protected/views/site/products.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->renderPartial('products');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
		
		if (Yii::app()->request->getQuery('soc_error_save'))
			Yii::app()->user->setFlash('error', tt('Error saving data. Please try again later.', 'socialauth'));
		if (Yii::app()->request->getQuery('deactivate'))
			showMessage(tc('Login'), tt('Your account not active. Administrator deactivate your account.', 'socialauth'), null, true);
		
		$service = Yii::app()->request->getQuery('service');
		if (isset($service)) {
			$authIdentity = Yii::app()->eauth->getIdentity($service);
			$authIdentity->redirectUrl = Yii::app()->user->returnUrl;
			$authIdentity->cancelUrl = $this->createAbsoluteUrl('site/login');
			
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
							$authIdentity->redirect(Yii::app()->createAbsoluteUrl('/site/login').'?soc_error_save=1');
						}
						
						$success = User::setSocialUid($user['id'], $uid, $service);
						
						if (!$success) {
							User::model()->findByPk($user['id'])->delete();
							$authIdentity->redirect(Yii::app()->createAbsoluteUrl('/site/login').'?soc_error_save=1');
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
								$authIdentity->redirect(Yii::app()->createAbsoluteUrl('/site/login').'?deactivate=1');
							if ($isNewUser) 
								$authIdentity->redirect(Yii::app()->createAbsoluteUrl('/site/setemailandpass').'/service/'.$service);
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

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
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
	
	public function actionSetEmailAndPass(){

		if(isset($_POST['User']))
		{
			if (Yii::app()->request->getQuery('service'))
				$service = Yii::app()->request->getQuery('service');
			$service_uid = Yii::app()->session['__eauth_'.$service.'__uid'];
			
			$social_user = User::model()->findByAttributes(array('service'=>$service,'identity'=>$service_uid,'email_entered'=>0));
			$current_user=$this->loadModel(Yii::app()->user->id);
			if($social_user && ($social_user->id == $current_user->id))	{
				$social_user->scenario = 'register';

				$social_user->attributes=$_POST['User'];
				$social_user->username = $_POST['User']['email'];

				if($social_user->validate()){
					$social_user->setPassword();
					$social_user->save(false);
					Yii::app()->user->setFlash('success', Yii::t('Your password successfully changed.'));
					$this->redirect(array('index'));
				}
			}
			else {
				Yii::app()->user->setFlash('success', Yii::t('There was some mistake with your identity, please contact administrators!'));
			}
		}
		else	{
			if (Yii::app()->request->getQuery('service'))
				$service = Yii::app()->request->getQuery('service');
			//$service_uid = Yii::app()->session['__eauth_'.$service.'__uid'];
			//var_dump(Yii::app()->session);
			//$social_user = User::model()->findByAttributes(array('service'=>$service,'identity'=>$service_uid,'email_entered'=>0));
			//$current_user=$this->loadModel(Yii::app()->user->id);
			//if($social_user && ($social_user->id == $current_user->id))	{
				$this->render('setemail',array(
					'model'=>Yii::app()->user,
				));
			//}
		}
	}
	
	public function loadModel($id = null, $resetScope = 0) {
		if($this->_model===null) {
			if($id == null){
				if(isset($_GET['id'])) {
					$model = new $this->modelName;
					if($resetScope){
						$this->_model=$model->resetScope()->findByPk($_GET['id']);
					}else{
						$this->_model=$model->findByPk($_GET['id']);
					}
				}
			}
			else{
				$model = new $this->modelName;
				if($resetScope){
					$this->_model=$model->resetScope()->findByPk($id);
				}else{
					$this->_model=$model->findByPk($id);
				}
			}

			if($this->_model===null){
				throw new CHttpException(404,'The requested page does not exist.');
			}
		}
		return $this->_model;
	}
}