<?php
$this->breadcrumbs=array(
	'Supplierfeedbacks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Supplierfeedback', 'url'=>array('index')),
	array('label'=>'Create Supplierfeedback', 'url'=>array('create')),
	array('label'=>'View Supplierfeedback', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Supplierfeedback', 'url'=>array('admin')),
);
?>

<h1>Update Supplierfeedback <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>