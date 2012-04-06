<?php
$this->breadcrumbs=array(
	'Productattrvalues'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Productattrvalue', 'url'=>array('index')),
	array('label'=>'Create Productattrvalue', 'url'=>array('create')),
	array('label'=>'View Productattrvalue', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Productattrvalue', 'url'=>array('admin')),
);
?>

<h1>Update Productattrvalue <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>