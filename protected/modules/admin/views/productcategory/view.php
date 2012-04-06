<?php
$this->breadcrumbs=array(
	'Productcategories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Productcategory', 'url'=>array('index')),
	array('label'=>'Create Productcategory', 'url'=>array('create')),
	array('label'=>'Update Productcategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Productcategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Productcategory', 'url'=>array('admin')),
);
?>

<h1>View Productcategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parentid',
		'name',
	),
)); ?>
