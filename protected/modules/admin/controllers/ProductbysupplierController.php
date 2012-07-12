<?php

class ProductbysupplierController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('create'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','update','delete','adminsupplierproducts','updateprice'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Productbysupplier;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Productbysupplier']))
		{
			$model->attributes=$_POST['Productbysupplier'];
			if($model->save())
			{
				if( Yii::app()->request->isAjaxRequest )
				{
					// Stop jQuery from re-initialization
					Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				
					echo CJSON::encode( array(
				    	'status' => 'success',
						'content' => 'Product category successfully created',
					));
					exit;
				}
				else
					$this->redirect(array('view','id'=>$model->id));
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
			$this->render('create',array(
				'model'=>$model,
			));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Productbysupplier']))
		{
			$model->attributes=$_POST['Productbysupplier'];
			if($model->save())
			{
				if( Yii::app()->request->isAjaxRequest )
				{
			        // Stop jQuery from re-initialization
			        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			        echo CJSON::encode( array(
			          'status' => 'success',
			          'content' => 'Product price successfully updated',
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
			$this->loadModel($id)->delete();

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
		$dataProvider=new CActiveDataProvider('Productbysupplier');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Productbysupplier('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productbysupplier']))
			$model->attributes=$_GET['Productbysupplier'];

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
		$model=Productbysupplier::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='productbysupplier-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Manages supplier-specific product prices
	 * @param integer $category_id the ID of category to be displayed
	 */
	public function actionAdminSupplierProducts()
	{
		if(isset($_GET['supplierid']))
		{
	        $supplier = Supplier::model()->findByPk($_GET['supplierid']);
	        //--------------------------------------------
	        //$cs=Yii::app()->getClientScript();
	        //Yii::app()->getClientScript()->registerScriptFile($cs->getCoreScriptUrl().'/jui/js'.'/'.'jquery-ui.min.js',CClientScript::POS_END);
	        //--------------------------------------------
			$this->renderPartial('_supplierpricelist',array(
				'supplier'=>$supplier,
				'products'=>$supplier->productsbysupplier
			),false,true);
		}
	}
	
	/**
	 * Updates price of product for supplier
	 * @param integer $category_id the ID of category to be displayed
	 */
	public function actionUpdatePrice()
	{
		if(isset($_POST['Productbysupplier']))
		{
			$model = Productbysupplier::model()->findByPk($_POST['Productbysupplier']['id']);
			if($model===null){
				throw new CHttpException(404,'The requested page does not exist.');
			}
	
			$model->attributes = $_POST['Productbysupplier'];
			if($model->save()){
				$product = Product::model()->findByPk($model->productid);
				$product->UpdateAvgMinMaxPrice();
				$product->save();
				echo $model->price;
			}
		}
	}
}
