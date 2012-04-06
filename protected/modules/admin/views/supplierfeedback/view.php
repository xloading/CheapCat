<?php
$this->breadcrumbs=array(
	'Supplierfeedbacks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Supplierfeedback', 'url'=>array('index')),
	array('label'=>'Create Supplierfeedback', 'url'=>array('create')),
	array('label'=>'Update Supplierfeedback', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Supplierfeedback', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Supplierfeedback', 'url'=>array('admin')),
);
?>

<h1>View Supplierfeedback #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'supplierid',
		'dateadded',
		'rating',
		'feedback',
	),
)); ?>
