<?php
class CAdminController extends Controller
{
    public $layout = 'column1';
    public $pageTitle;

    public function accessRules()
    {
        return array(
            array('allow',
                  'users' => array('admin'),
            ),
            array('deny', // deny all users
                  'users' => array('*'),
            ),
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        /*return array(
            'accessControl', // perform access control for CRUD operations
        );*/
    }

    public function setNotice($message)
    {
        return Yii::app()->user->setFlash('notice', $message);
    }

    public function setError($message)
    {
        return Yii::app()->user->setFlash('error', $message);
    }

	/*public function init() {
        $this->pageTitle = Yii::app()->name;
    }

	public function render($view, $data = null) {
        if (isset($_SERVER['HTTP_X_PJAX'])) {
            echo CHtml::tag('title', array(), $this->pageTitle);
            $this->renderPartial($view, $data);
        }
        else
            parent::render($view, $data);
    }*/
}
?>