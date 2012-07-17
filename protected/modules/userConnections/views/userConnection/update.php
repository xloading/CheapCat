<?php
$this->breadcrumbs=array(
	'User Connections'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserConnection', 'url'=>array('index')),
	array('label'=>'Create UserConnection', 'url'=>array('create')),
	array('label'=>'View UserConnection', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserConnection', 'url'=>array('admin')),
);
?>

<h1>Update UserConnection <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>