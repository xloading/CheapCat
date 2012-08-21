<?php
/**********************************************************************************************
*                            CMS Open Real Estate
*                              -----------------
*	version				:	1.3.1
*	copyright			:	(c) 2012 Monoray
*	website				:	http://www.monoray.ru/
*	contact us			:	http://www.monoray.ru/contact
*
* This file is part of CMS Open Real Estate
*
* Open Real Estate is free software. This work is licensed under a GNU GPL.
* http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
* Open Real Estate is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
* Without even the implied warranty of  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
***********************************************************************************************/

class MainController extends ModuleUserController {
	public $modelName = 'User';

	public function filters(){
		return array(
			'accessControl',
		);
	}

	public function accessRules(){
		return array(
			array(
				'allow',
				'users'=>array('@'),
			),
			array(
				'deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex(){
		$model=$this->loadModel(Yii::app()->user->id);
		
		$socSuccess = Yii::app()->request->getQuery('soc_success');
		if ($socSuccess) 
			Yii::app()->user->setFlash('error', tt('During export account data may be generate random email and password. Please change it.', 'socialauth'));
		
		if(!$socSuccess && preg_match("/null\.io/i", $model->email))
			Yii::app()->user->setFlash('error', tt('Please change your email and password!', 'socialauth'));
					
		if(isset($_POST[$this->modelName])){
			if(isset($_POST['changePassword']) && $_POST['changePassword']){
				$model->scenario = 'changePass';

				$model->attributes=$_POST[$this->modelName];
				
				if($model->validate()){
					$model->setPassword();
					$model->save(false);
					Yii::app()->user->setFlash('success', tt('Your password successfully changed.'));
					$this->redirect(array('index'));
				}
			}
			else{
				$model->scenario = 'usercpanel';
				$model->attributes=$_POST[$this->modelName];
			
				if($model->save()){
					if($model->scenario == 'usercpanel'){
						Yii::app()->user->setFlash('success', tt('Your details successfully changed.'));
					}
					$this->redirect(array('index'));
				}
			}
		}

		$this->render('index',array(
			'model' => $this->loadModel(Yii::app()->user->id),
		));
	}
}

