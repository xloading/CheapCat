<?php
$this->breadcrumbs=array(
	'User Connections'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserConnection', 'url'=>array('index')),
	array('label'=>'Manage UserConnection', 'url'=>array('admin')),
);
?>

<h1>Create UserConnection</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>