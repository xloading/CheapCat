<?php
$this->breadcrumbs=array(
	'Productratings'=>array('index'),
	$model->productid,
);

$this->menu=array(
	array('label'=>'List Productrating', 'url'=>array('index')),
	array('label'=>'Create Productrating', 'url'=>array('create')),
	array('label'=>'Update Productrating', 'url'=>array('update', 'id'=>$model->productid)),
	array('label'=>'Delete Productrating', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->productid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Productrating', 'url'=>array('admin')),
);
?>

<h1>View Productrating #<?php echo $model->productid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'productid',
		'averating',
		'ratecounter',
	),
)); ?>
