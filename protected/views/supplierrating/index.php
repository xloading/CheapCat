<?php
$this->breadcrumbs=array(
	'Supplierratings',
);

$this->menu=array(
	array('label'=>'Create Supplierrating', 'url'=>array('create')),
	array('label'=>'Manage Supplierrating', 'url'=>array('admin')),
);
?>

<h1>Supplierratings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
