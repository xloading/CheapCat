<?php
$this->breadcrumbs=array(
	'Supplierratings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Supplierrating', 'url'=>array('index')),
	array('label'=>'Manage Supplierrating', 'url'=>array('admin')),
);
?>

<h1>Create Supplierrating</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>