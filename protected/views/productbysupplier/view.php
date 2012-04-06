<?php
$this->breadcrumbs=array(
	'Productbysuppliers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Productbysupplier', 'url'=>array('index')),
	array('label'=>'Create Productbysupplier', 'url'=>array('create')),
	array('label'=>'Update Productbysupplier', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Productbysupplier', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Productbysupplier', 'url'=>array('admin')),
);
?>

<h1>View Productbysupplier #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'supplierid',
		'productid',
		'price',
	),
)); ?>
