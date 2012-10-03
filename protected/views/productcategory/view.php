<?php
$this->pageTitle=$model->name;
if($this->beginCache('catalog-'.$model->id, array('duration'=>60))) {
	$children = $model->children()->findAll();
	if(isset($children) && (count($children)>0))	{
		$this->beginWidget('application.components.Categories', array(
		  'categories' => $children
		));
		$this->endWidget();
	}
	$this->endCache();
}
//if($this->beginCache('productlist-'.$model->id, array('duration'=>60))) {
	$products = Product::model()->findAllByAttributes(array('categoryid'=>$model->id));
	if(isset($products) && (count($products)>0))	{
		$this->beginWidget('application.components.ProductList', array(
		  'products' => $products
		));
		$this->endWidget();
	}
	/*$this->endCache();
}*/
?>
