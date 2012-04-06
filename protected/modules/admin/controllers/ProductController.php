<?php

class ProductController extends CAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='/layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','admincategoryproducts','uploadimage','updateimage','attrlist','productsbycategorylist'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if( Yii::app()->request->isAjaxRequest )
      	{
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			
			echo CJSON::encode( array(
				'status' => 'failure',
				'content' => $this->renderPartial( 'view', array(
				'model' => $this->loadModel($id) ), true, true ),
			));
			exit;
      	}
      	else
      	{
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
      	}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Product;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];
			
			// \/ Process image \/
			$image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/upload/'.$model->largepic);
			$imageName = $model->genImageName();
			$image->resize(200, 200, IMAGE::AUTO)->quality(75)->sharpen(20);
			$image->save(CHtml::normalizeUrl(Yii::getPathOfAlias('webroot').'/images/products/large/'.$imageName), False);
			$image->resize(100, 100, IMAGE::AUTO)->quality(75)->sharpen(20);
			$image->save(CHtml::normalizeUrl(Yii::getPathOfAlias('webroot').'/images/products/small/'.$imageName), False);
			$model->largepic = CHtml::normalizeUrl('/images/products/large/'.$imageName);
			$model->smallpic = CHtml::normalizeUrl('/images/products/small/'.$imageName);
			// /\ Process image /\
			
			if($model->save())	{
				
				$model->SaveAttrs($_POST['Product']['attr']);

				if( Yii::app()->request->isAjaxRequest )
				{
			        // Stop jQuery from re-initialization
			        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			        echo CJSON::encode( array(
			          'status' => 'success',
			          'content' => 'Product successfully updated',
			        ));
			        exit;
			    }
			    else	{
					$this->redirect(array('view','id'=>$model->id));
			    }
			}
		}

		if( Yii::app()->request->isAjaxRequest )
		{
		  // Stop jQuery from re-initialization
		  Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		
		  echo CJSON::encode( array(
		    'status' => 'failure',
		    'content' => $this->renderPartial( '_form', array(
		    'model' => $model ), true, true ),
		  ));
		  exit;
		}
		else	{
			$this->render('create',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		
		$model_old=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];
			
			// \/ Process image \/
			/*$model->uploadedFile=CUploadedFile::getInstance($model,'uploadedFile');
			$image = Yii::app()->image->load($model->uploadedFile->tempName);
			$imageName = $model->genImageName();
			$image->resize(200, 200, IMAGE::AUTO)->quality(75)->sharpen(20);
			$image->save(CHtml::normalizeUrl(Yii::getPathOfAlias('webroot').'/images/products/large/'.$imageName), False);
			$image->resize(100, 100, IMAGE::AUTO)->quality(75)->sharpen(20);
			$image->save(CHtml::normalizeUrl(Yii::getPathOfAlias('webroot').'/images/products/small/'.$imageName), False);
			$model->largepic = CHtml::normalizeUrl(Yii::getPathOfAlias('webroot').'/images/products/large/'.$imageName);
			$model->smallpic = CHtml::normalizeUrl(Yii::getPathOfAlias('webroot').'/images/products/small/'.$imageName);*/
			// /\ Process image /\
			if(strlen($model_old->largepic)!==0 && ($model->largepic != $model_old->largepic))
			{
				@unlink(Yii::getPathOfAlias('webroot').$model_old->largepic);
				@unlink(Yii::getPathOfAlias('webroot').$model_old->smallpic);
			}

			$transaction=$model->dbConnection->beginTransaction();
			try
			{
				if($model->save())	{
					$model->SaveAttrs($_POST['Product']['attr']);
					$transaction->commit();

					if( Yii::app()->request->isAjaxRequest )
					{
				        // Stop jQuery from re-initialization
				        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				        echo CJSON::encode( array(
				          'status' => 'success',
				          'content' => 'Product successfully updated',
				        ));
				        exit;
				    }
				    else	{
						$this->redirect(array('view','id'=>$model->id));
				    }
				}
			}
			catch(Exception $e)
			{
			    $transaction->rollBack();
			    $errors = $model->getErrors();
			    // Stop jQuery from re-initialization
		        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		        echo CJSON::encode( array(
		          'status' => 'success',
		          'content' => $errors,
		        ));
		        exit;
			}
				
		}
		
		if( Yii::app()->request->isAjaxRequest )
		{
		  // Stop jQuery from re-initialization
		  Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		
		  echo CJSON::encode( array(
		    'status' => 'failure',
		    'content' => $this->renderPartial( '_form', array(
		    'model' => $model ), true, true ),
		  ));
		  exit;
		}
		else
			$this->render('update',array(
				'model'=>$model,
			));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel($id);
			$model->delete();
			
			if(strlen($model->largepic)!==0)
			{
				@unlink(Yii::getPathOfAlias('webroot').$model->largepic);
				@unlink(Yii::getPathOfAlias('webroot').$model->smallpic);
			}

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Product');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product']))
			$model->attributes=$_GET['Product'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function setFlash( $key, $value, $defaultValue = null )
	{
	  Yii::app()->user->setFlash( $key, $value, $defaultValue );
	}
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Manages category-specific products
	 * @param integer $category_id the ID of category to be displayed
	 */
	public function actionAdminCategoryProducts()
	{
		if(isset($_GET['id']))
		{
	        $category = Productcategory::model()->findByPk($_GET['id']);
	        //--------------------------------------------
	        $cs=Yii::app()->getClientScript();
	        Yii::app()->getClientScript()->registerScriptFile($cs->getCoreScriptUrl().'/jui/js'.'/'.'jquery-ui.min.js',CClientScript::POS_END);
	        //--------------------------------------------
			$this->renderPartial('_adminlist',array(
				'model'=>$category,
				'products'=>$category->products
			),false,true);
		}
	}
	
	public function actions()
	{
	  return array(
	    'update' => 'application.actions.UpdateAction',
	  );
	}
	
	public function actionUploadImage()
	{
	        Yii::import("ext.EAjaxUpload.qqFileUploader");

                $folder=Yii::getPathOfAlias('webroot').'/upload/';// folder for uploaded files
                $allowedExtensions = array("jpg");//array("jpg","jpeg","gif","exe","mov" and etc...
                $sizeLimit = 1 * 1024 * 1024;// maximum file size in bytes
                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
                $result = $uploader->handleUpload($folder);
                $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
                echo $result;// it's array
	}
	
	public function actionUpdateImage()
	{
	        Yii::import("ext.EAjaxUpload.qqFileUploader");

                $folder=Yii::getPathOfAlias('webroot').'/upload/';// folder for uploaded files
                $allowedExtensions = array("jpg");//array("jpg","jpeg","gif","exe","mov" and etc...
                $sizeLimit = 1 * 1024 * 1024;// maximum file size in bytes
                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
                $result = $uploader->handleUpload($folder);
                $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/upload/'.$result['filename']);
                $model = new Product();
                $imageName = $model->genImageName();
				$image->resize(200, 200, IMAGE::AUTO)->quality(75)->sharpen(20);
				$image->save(CHtml::normalizeUrl(Yii::getPathOfAlias('webroot').'/images/products/large/'.$imageName), False);
				$image->resize(100, 100, IMAGE::AUTO)->quality(75)->sharpen(20);
				$image->save(CHtml::normalizeUrl(Yii::getPathOfAlias('webroot').'/images/products/small/'.$imageName), False);
				$model->largepic = CHtml::normalizeUrl('/images/products/large/'.$imageName);
				$model->smallpic = CHtml::normalizeUrl('/images/products/small/'.$imageName);
                $result['smallpic'] = $model->smallpic;
                $result['largepic'] = $model->largepic;
				$result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
                echo $result;// it's array
	}
	
	public function actionAttrList()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['id']) && isset($_POST['categoryid'])) {
                if ($_POST['id'] != '0') {
                    $model = $this->loadModel($_POST['id']);
                    $model->categoryid = $_POST['categoryid'];
                } else {
                    $model = new Product;
                    $model->categoryid = $_POST['categoryid'];
                }
            	if (isset($model->category))
				{
					$attrGroupList = array();
					if(($model->category->inherit_attrs_from_parent == 1) && ($model->category->id !== 0))	{
						$category = Productcategory::model()->findByPk($model->category->parentid);
						foreach($category->attrs as $attrList)
						{
							if(!in_array($attrList->group_id,$attrGroupList))
							{
								$attrGroupList[] = $attrList->group_id;
							}
						}
						$attrGroups = Attributegroup::model()->findAllByPk($attrGroupList);
						$this->renderPartial('attrs', array(
													'model' => $model,
													'attrgrouplist' => $attrGroups,
													'category' => $category
		                                         ));
					}
					else {
						foreach($model->category->attrs as $attrList)
						{
							if(!in_array($attrList->group_id,$attrGroupList))
							{
								$attrGroupList[] = $attrList->group_id;
							}
						}
						$attrGroups = Attributegroup::model()->findAllByPk($attrGroupList);
						$this->renderPartial('attrs', array(
													'model' => $model,
													'attrgrouplist' => $attrGroups,
													'category' => $model->category
		                                         ));
					}
				}
            }
        }
    }
    
	public function actionProductsByCategoryList()
    {
        if (Yii::app()->request->isAjaxRequest) {
        	$category_id = Yii::app()->getRequest()->getPost('categoryid');
            if (isset($category_id)) {
				$category = Productcategory::model()->findByPk($category_id);
				$this->renderPartial('_productsbycategorylist', array(
											'category' => $category
                                         ));
            }
        }
    }
	
}
