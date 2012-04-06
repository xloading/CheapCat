<?php
$this->breadcrumbs=array(
	'Productbysuppliers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Productbysupplier', 'url'=>array('index')),
	array('label'=>'Create Productbysupplier', 'url'=>array('create')),
	array('label'=>'View Productbysupplier', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Productbysupplier', 'url'=>array('admin')),
);
?>

<h1>Update Productbysupplier <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>