<?php
$this->breadcrumbs=array(
	'Productbysuppliers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Productbysupplier', 'url'=>array('index')),
	array('label'=>'Manage Productbysupplier', 'url'=>array('admin')),
);
?>

<h1>Create Productbysupplier</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>