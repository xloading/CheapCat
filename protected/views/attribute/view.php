<?php
$this->breadcrumbs=array(
	'Attributes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Attribute', 'url'=>array('index')),
	array('label'=>'Create Attribute', 'url'=>array('create')),
	array('label'=>'Update Attribute', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Attribute', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Attribute', 'url'=>array('admin')),
);
?>

<h1>View Attribute #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'group_id',
		'in_brief',
		'type',
		'grouporder',
		'dimension',
		'brieforder',
		'in_filter',
	),
)); ?>
