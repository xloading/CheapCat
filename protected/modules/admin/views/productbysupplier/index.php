<?php
$this->breadcrumbs=array(
	'Productbysuppliers',
);

$this->menu=array(
	array('label'=>'Create Productbysupplier', 'url'=>array('create')),
	array('label'=>'Manage Productbysupplier', 'url'=>array('admin')),
);
?>

<h1>Productbysuppliers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
