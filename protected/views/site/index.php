<?php
$this->pageTitle=Yii::app()->name;
if($this->beginCache('fullcatalog', array('duration'=>60))) {
	$category=Productcategory::model()->findByPk(0);
	$children = $category->children()->findAll();
	$this->widget('application.components.Categories', array(
	  'categories' => $children
	));
	$this->endCache();
}
?>
