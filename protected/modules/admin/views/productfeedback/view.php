<?php
$this->breadcrumbs=array(
	'Productfeedbacks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Productfeedback', 'url'=>array('index')),
	array('label'=>'Create Productfeedback', 'url'=>array('create')),
	array('label'=>'Update Productfeedback', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Productfeedback', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Productfeedback', 'url'=>array('admin')),
);
?>

<h1>View Productfeedback #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'productid',
		'dateadded',
		'rating',
		'feedback',
	),
)); ?>
