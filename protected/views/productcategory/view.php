<?php
$this->pageTitle=$model->name;
if($this->beginCache('catalog-'.$model->id, array('duration'=>60))) {
	$children = $model->children()->findAll();
	$this->widget('application.components.Categories', array(
	  'categories' => $children
	));
	$this->endCache();
}
if($this->beginCache('productlist-'.$model->id, array('duration'=>60))) {
	$products = Product::model()->findAllByAttributes(array('categoryid'=>$model->id));
	$this->widget('application.components.ProductList', array(
	  'products' => $products
	));
	$this->endCache();
}
?>
