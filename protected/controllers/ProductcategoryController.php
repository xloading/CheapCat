<?php

class ProductcategoryController extends Controller
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
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','ajaxfilltree'),
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
		$model=new Productcategory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Productcategory']))
		{
			$model->attributes=$_POST['Productcategory'];
			if($model->save())	{
				if( Yii::app()->request->isAjaxRequest )
				{
					// Stop jQuery from re-initialization
					Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				
					echo CJSON::encode( array(
				    	'status' => 'successcategory',
						'content' => 'ModelName successfully created',
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

		if(isset($_POST['Productcategory']))
		{
			$model->attributes=$_POST['Productcategory'];
			if($model->save())
			{
				if( Yii::app()->request->isAjaxRequest )
			    {
			      // Stop jQuery from re-initialization
			      Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			
			      echo CJSON::encode( array(
			        'status' => 'successcategory',
			        'content' => 'ModelName successfully updated',
			      	'option'=>CHtml::tag('option',array (
                                                        'value'=>$model->id,
                                                        'selected'=>true), CHtml::encode($model->id),true)
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
		$model = $this->loadModel($id);
		if( Yii::app()->request->isAjaxRequest )
		{
			// Stop jQuery from re-initialization
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		
			if( isset( $_POST['confirmDelete'] ) && $_POST['confirmDelete'] )
			{
				$model->delete();
				echo CJSON::encode( array(
					'status' => 'successcategory',
					'content' => 'Deleted succussfully',
				));
				exit;
			}
			else if( isset( $_POST['confirmDeleteWithProducts'] ) && $_POST['confirmDeleteWithProducts'] )
			{
				$transaction = Yii::app()->db->beginTransaction();
				try
				{
					foreach($model->products as $product)
					{
						$product->delete();
					}
					$model->delete();
					$transaction->commit();
				}
				catch(Exception $e)
				{
					$transaction->rollBack();
				}
				echo CJSON::encode( array(
					'status' => 'successcategory',
					'content' => 'Deleted succussfully',
				));
				exit;
			}
			else if( isset( $_POST['confirmDeleteWithoutProducts'] ) && $_POST['confirmDeleteWithoutProducts'] )
			{
				$transaction = Yii::app()->db->beginTransaction();
				try
				{
					foreach($model->products as $product)
					{
						$product->categoryid = 0;
						$product->save();
					}
					$model->delete();
					$transaction->commit();
				}
				catch(Exception $e)
				{
					$transaction->rollBack();
				}
				echo CJSON::encode( array(
					'status' => 'successcategory',
					'content' => 'Deleted succussfully',
				));
				exit;
			}
			else if( isset( $_POST['denyDelete'] ) && $_POST['denyDelete'])
			{
				echo CJSON::encode( array(
					'status' => 'canceled',
					'content' => 'Deletion canceled',
				));
				exit;
			}
			else
			{
				echo CJSON::encode( array(
					'status' => 'failure',
					'content' => $this->renderPartial( '_delete', array(
						'model' => $model, 'products' => $model->products), true, true ),
				));
				exit;
			}
		}
		else
		{
			if( isset( $_POST['confirmDelete'] ) )
			{
				$model->delete();
				$this->redirect( array( 'admin' ) );
			}
			else if( isset( $_POST['denyDelete'] ) )
				$this->redirect( array( 'view', 'id' => $model->id ) );
			else
				$this->render( 'delete', array( 'model' => $model ) );
	  	}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Productcategory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Productcategory(/*'search'*/);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productcategory']))
			$model->attributes=$_GET['Productcategory'];

		$this->renderPartial('admin',
			array(
				'model' => $model,
				'products' => $model->products,
			),
			false,
			true);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Productcategory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/*public function loadModel()
	{
	  if( $this->_model === null )
	  {
	    if( isset( $_GET['id'] ) )
	      $this->_model = ModelName::model()->findByPk( (int) $_GET['id'] );
	    if( $this->_model === null )
	      throw new CHttpException( 404, 'The requested page does not exist.' );
	  }
	  return $this->_model;
	}*/
	
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='productcategory-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAjaxFillTree()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            exit();
        }
        $parentId = "NULL";
        if (isset($_GET['root']) && $_GET['root'] !== 'source') {
            $parentId = (int) $_GET['root'];
        }
        $req = Yii::app()->db->createCommand(
            "SELECT m1.id, m1.name AS text, m2.id IS NOT NULL AS hasChildren "
            . "FROM productcategories AS m1 LEFT JOIN productcategories AS m2 ON m1.id=m2.parentid "
            . "WHERE m1.parentid <=> $parentId "
            . "GROUP BY m1.id ORDER BY m1.name ASC"
        );
        $children = $req->queryAll();
        echo str_replace(
            '"hasChildren":"0"',
            '"hasChildren":false',
            CTreeView::saveDataAsJson($children)
        );
        exit();
    }
    
	public function actions()
	{
	  return array(
	    'update' => 'application.actions.UpdateAction',
	  );
	}
}
