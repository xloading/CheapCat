<?php
$this->breadcrumbs=array(
	'Productcategories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Productcategory', 'url'=>array('index')),
	array('label'=>'Create Productcategory', 'url'=>array('create')),
	array('label'=>'View Productcategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Productcategory', 'url'=>array('admin')),
);
?>

<h1>Update Productcategory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>