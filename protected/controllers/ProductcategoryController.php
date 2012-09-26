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
	public function actionView($slug)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($slug),
		));
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($slug)
	{
		$model=Productcategory::model()->findByAttributes(array('slug'=>$slug));
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
