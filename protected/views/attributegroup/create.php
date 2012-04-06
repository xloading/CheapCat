<?php
$this->breadcrumbs=array(
	'Attributegroups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Attributegroup', 'url'=>array('index')),
	array('label'=>'Manage Attributegroup', 'url'=>array('admin')),
);
?>

<h1>Create Attributegroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>