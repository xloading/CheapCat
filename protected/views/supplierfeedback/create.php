<?php
$this->breadcrumbs=array(
	'Supplierfeedbacks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Supplierfeedback', 'url'=>array('index')),
	array('label'=>'Manage Supplierfeedback', 'url'=>array('admin')),
);
?>

<h1>Create Supplierfeedback</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>