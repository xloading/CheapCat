<?php
$this->breadcrumbs=array(
	'Attributegroups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Attributegroup', 'url'=>array('index')),
	array('label'=>'Create Attributegroup', 'url'=>array('create')),
	array('label'=>'View Attributegroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Attributegroup', 'url'=>array('admin')),
);
?>

<h1>Update Attributegroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>