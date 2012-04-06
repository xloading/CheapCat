<?php

class AjaxController extends СController {

    public $layout = 'column1';
    //public $breadcrumbs;
    public $pageTitle;

    public function init() {
        $this->pageTitle = Yii::app()->name;
    }

    public function render($view, $data = null) {
        if (isset($_SERVER['HTTP_X_PJAX'])) {
            echo CHtml::tag('title', array(), $this->pageTitle);
            $this->renderPartial($view, $data);
        }
        else
            parent::render($view, $data);
    }

}
?>