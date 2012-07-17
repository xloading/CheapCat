<?php
$this->breadcrumbs=array(
	'User Connections'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List UserConnection', 'url'=>array('index')),
	array('label'=>'Create UserConnection', 'url'=>array('create')),
	array('label'=>'Update UserConnection', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserConnection', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserConnection', 'url'=>array('admin')),
);
?>

<h1>View UserConnection #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'name',
		'service_user_id',
	),
)); ?>
