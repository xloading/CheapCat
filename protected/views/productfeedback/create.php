<?php
$this->breadcrumbs=array(
	'Productfeedbacks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Productfeedback', 'url'=>array('index')),
	array('label'=>'Manage Productfeedback', 'url'=>array('admin')),
);
?>

<h1>Create Productfeedback</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>