<?php
$this->breadcrumbs=array(
	'Productattrvalues'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Productattrvalue', 'url'=>array('index')),
	array('label'=>'Manage Productattrvalue', 'url'=>array('admin')),
);
?>

<h1>Create Productattrvalue</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>