<?php
$this->breadcrumbs=array(
	'Productratings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Productrating', 'url'=>array('index')),
	array('label'=>'Manage Productrating', 'url'=>array('admin')),
);
?>

<h1>Create Productrating</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>