<?php
$this->breadcrumbs=array(
	'Attrvaluelists'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Attrvaluelist', 'url'=>array('index')),
	array('label'=>'Create Attrvaluelist', 'url'=>array('create')),
	array('label'=>'Update Attrvaluelist', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Attrvaluelist', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Attrvaluelist', 'url'=>array('admin')),
);
?>

<h1>View Attrvaluelist #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'attr_id',
		'value',
	),
)); ?>
