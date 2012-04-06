<?php
$this->breadcrumbs=array(
	'Productattrvalues'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Productattrvalue', 'url'=>array('index')),
	array('label'=>'Create Productattrvalue', 'url'=>array('create')),
	array('label'=>'Update Productattrvalue', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Productattrvalue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Productattrvalue', 'url'=>array('admin')),
);
?>

<h1>View Productattrvalue #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product_id',
		'attr_id',
		'attrlistvalue_id',
		'value',
	),
)); ?>
