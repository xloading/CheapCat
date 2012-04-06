<?php
$this->breadcrumbs=array(
	'Productcategories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Productcategory', 'url'=>array('index')),
	array('label'=>'Manage Productcategory', 'url'=>array('admin')),
);
?>

<h1>Create Productcategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>