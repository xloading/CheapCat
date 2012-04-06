<?php
$this->breadcrumbs=array(
	'Attrvaluelists'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Attrvaluelist', 'url'=>array('index')),
	array('label'=>'Manage Attrvaluelist', 'url'=>array('admin')),
);
?>

<h1>Create Attrvaluelist</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>