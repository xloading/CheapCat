<?php
$this->breadcrumbs=array(
	'Attributegroups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Attributegroup', 'url'=>array('index')),
	array('label'=>'Create Attributegroup', 'url'=>array('create')),
	array('label'=>'Update Attributegroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Attributegroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Attributegroup', 'url'=>array('admin')),
);
?>

<h1>View Attributegroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		//'position',
	),
)); ?>
