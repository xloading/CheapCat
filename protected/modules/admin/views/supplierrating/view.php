<?php
$this->breadcrumbs=array(
	'Supplierratings'=>array('index'),
	$model->supplierid,
);

$this->menu=array(
	array('label'=>'List Supplierrating', 'url'=>array('index')),
	array('label'=>'Create Supplierrating', 'url'=>array('create')),
	array('label'=>'Update Supplierrating', 'url'=>array('update', 'id'=>$model->supplierid)),
	array('label'=>'Delete Supplierrating', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->supplierid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Supplierrating', 'url'=>array('admin')),
);
?>

<h1>View Supplierrating #<?php echo $model->supplierid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'supplierid',
		'averating',
		'ratecounter',
	),
)); ?>
