<?php

class UserController extends Controller
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','setemailandpass'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
		        'condition'=>'status>'.User::STATUS_BANED,
		    ),
				
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
	/**
	 * Init action taken from Lily's UserController
	 * @param string $action Init action (start, finish or next)
	 * @throws CHttpException
	 */
    public function actionInit($action){
        if(!LilyModule::instance()->userIniter->isStarted) throw new CHttpException(404);
        if(($action=='start' && LilyModule::instance()->userIniter->stepId == 0)||($action=='finish' && LilyModule::instance()->userIniter->stepId
            == LilyModule::instance()->userIniter->count-1)){
        $this->render('init', array('action'=>$action));
        }else if($action == 'next'){
            LilyModule::instance()->userIniter->nextStep();
        }else throw new CHttpException(404);
    }
    
	public function actionSetEmailAndPass(){
		if(isset($_POST['User']))
		{
			if (Yii::app()->request->getQuery('service'))
				$service = Yii::app()->request->getQuery('service');
			$service_uid = Yii::app()->session['__eauth_'.$service.'__uid'];
			
			$social_user = User::model()->findByAttributes(array('service'=>$service,'identity'=>$service_uid,'email_entered'=>0));
			$current_user=User::model()->findByPk(Yii::app()->user->id);
			if($social_user && ($social_user->id == $current_user->id))	{
				$social_user->scenario = 'register';

				$social_user->attributes=$_POST['User'];
				$social_user->username = $_POST['User']['email'];

				if($social_user->validate()){
					$social_user->setPassword();
					$social_user->save(false);
					showMessage('success', UserModule::t('Thank you for your registration.'));
					$this->redirect(array('index'));
				}
			}
			else {
				showMessage('failure', UserModule::t('There was some mistake with your identity, please contact administrators!'));
			}
		}
		else	{
			if (Yii::app()->request->getQuery('service'))
				$service = Yii::app()->request->getQuery('service');
			//$service_uid = Yii::app()->session['__eauth_'.$service.'__uid'];
			//var_dump(Yii::app()->session);
			//$social_user = User::model()->findByAttributes(array('service'=>$service,'identity'=>$service_uid,'email_entered'=>0));
			//$current_user=User::model()->findByPk(Yii::app()->user->id);
			//if($social_user && ($social_user->id == $current_user->id))	{
				$this->render('setemail',array(
					'model'=>User::model()->findByPk(Yii::app()->user->id),
				));
			//}
		}
	}
}
