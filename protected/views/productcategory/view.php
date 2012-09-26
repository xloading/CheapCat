<?php
$this->pageTitle=$model->name;
if($this->beginCache('fullcatalog-'.$model->id, array('duration'=>60))) {
	$children = $model->children()->findAll();
	$this->widget('application.components.Categories', array(
	  'categories' => $children
	));
	$this->endCache();
}
?>
