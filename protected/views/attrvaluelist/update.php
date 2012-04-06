<?php
$this->breadcrumbs=array(
	'Attrvaluelists'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Attrvaluelist', 'url'=>array('index')),
	array('label'=>'Create Attrvaluelist', 'url'=>array('create')),
	array('label'=>'View Attrvaluelist', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Attrvaluelist', 'url'=>array('admin')),
);
?>

<h1>Update Attrvaluelist <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>