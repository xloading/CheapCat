<?php

class AttributeController extends CAdminController
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
				'actions'=>array('admin','delete','admingroupattributes','linkwithcategories'),
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
		$model=new Attribute;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Attribute']))
		{
			$model->attributes=$_POST['Attribute'];
			if($model->save())
			{
				if( Yii::app()->request->isAjaxRequest )
				{
			        // Stop jQuery from re-initialization
			        Yii::app()->clientScript->scriptMap['jquery.js'] = false;

			        echo CJSON::encode( array(
			          'status' => 'success',
			          'content' => 'Attribute successfully updated',
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
		{
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Attribute']))
		{
			$model->attributes=$_POST['Attribute'];
			if($model->save())	{
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
		$dataProvider=new CActiveDataProvider('Attribute');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Attribute('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Attribute']))
			$model->attributes=$_GET['Attribute'];

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
		$model=Attribute::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='attribute-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Manages group-specific attributes
	 * @param integer $category_id the ID of category to be displayed
	 */
	public function actionAdminGroupAttributes()
	{
		if(isset($_GET['id']))
		{
	        $attrGroup = Attributegroup::model()->findByPk($_GET['id']);
			$this->renderPartial('_adminlist',array(
				'model'=>$attrGroup,
				'attributes'=>$attrGroup->attributes
			),false,true);
		}
	}
	
	/**
	 * Manages linking between attributes and categories
	 * @param integer $category_id the ID of category to be displayed
	 */
	public function actionLinkWithCategories()
	{
		if (isset($_GET['categoryid']))
		{
			if (isset($_POST['SaveAttrs']))
		    {
		        // Since we converted the Javascript array to a string,
		        // convert the string back to a PHP array
		        $models = explode('&', $_POST['SaveAttrs']);
		        $attrsToLink = array();
		        foreach($models as $key => $attrstr)
		        {
		        	if(stripos($attrstr, 'attr[') !== False)
		        	{
		        		$attrsToLink[] =  (int) substr($attrstr,strpos($attrstr,'[')+1,strpos($attrstr,']')+1);
		        	}
		        }
		        
		        $model = Productcategory::model()->findByPk($_GET['categoryid']);
		        $model->attrs = $attrsToLink;
		        $model->save();
		        echo CJSON::encode( array(
					'status' => 'success',
					'content' => 'Attributes saved'//var_dump($attrsToLink),
				));
				exit;
		 
		        /*for ($i = 0; $i < sizeof($models); $i++)
		        {
		            if ($model = YourClass::model()->findbyPk($models[$i]))
		            {
		                $model->weight = $i;
		 
		                $model->save();
		            }
		        }*/
		    }
		    else
		    {
				$category = Productcategory::model()->findByPk($_GET['categoryid']);
				if( Yii::app()->request->isAjaxRequest )
				{
					$this->renderPartial('_linkwithcategories',array(
						'category'=>$category,
						//'attributes'=>$attrGroup->attributes
					),false,true);
				}
		    }
		}
	}
	
	/**
     * Returns array of attribute groups with linked to given category attributes
     * @return string attribute type
     */
	public function GetLinkedToCategory($category_id) {
		$attrGroupList = Attributegroup::model()->findAll();
		$attr_query = new CDbCriteria;
		$attr_query->select = 'name';
		$resultTree = array();
		foreach ($attrGroupList as $attrGroup)
		{
			$groupAttrList = Attribute::model()->with('productcategories'/*, array('category_id' => $category_id)*/)->findAllByAttributes(
							array('group_id' => $attrGroup->id),
							'productcategories_productcategories.category_id = '.$category_id
							/*,
							$attr_query*/);
			$groupAttrs = array();
			foreach ($groupAttrList as $groupAttr)
			{
				$groupAttrs['attr-'.$groupAttr->id] = $groupAttr->name;
			}
			if(!empty($groupAttrs))
			{
				$resultTree = array_merge($resultTree,array('attrgroup-'.$attrGroup->id => array($attrGroup->name => $groupAttrs)));
			}
			else
			{
				$resultTree = array_merge($resultTree,array('attrgroup-'.$attrGroup->id => $attrGroup->name));
			}
		}
		//var_dump($resultTree);
		return $resultTree;
	}
	
	/**
     * Returns array of attribute groups with unlinked to given category attributes
     * @return string attribute type
     */
	public function GetUnassigned($category_id) {
		$attrGroupList = Attributegroup::model()->findAll();
		$attr_query = new CDbCriteria;
		$attr_query->select = 'name';
		$resultTree = array();
		foreach ($attrGroupList as $attrGroup)
		{
			$groupAttrList = Attribute::model()->findAllByAttributes(
							array('group_id' => $attrGroup->id),
							'id not in (select attribute_id from categoryattribute ca where ca.category_id = '.$category_id.')'
							/*,
							$attr_query*/);
			$groupAttrs = array();
			foreach ($groupAttrList as $groupAttr)
			{
				$groupAttrs['attr-'.$groupAttr->id] = $groupAttr->name;
			}
			if(!empty($groupAttrs))
			{
				$resultTree = array_merge($resultTree,array('attrgroup-'.$attrGroup->id => array($attrGroup->name => $groupAttrs)));
			}
			else
			{
				$resultTree = array_merge($resultTree,array('attrgroup-'.$attrGroup->id => $attrGroup->name));
			}
		}
		//var_dump($resultTree);
		return $resultTree;
	}
}
