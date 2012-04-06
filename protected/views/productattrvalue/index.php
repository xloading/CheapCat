<?php
$this->breadcrumbs=array(
	'Productattrvalues',
);

$this->menu=array(
	array('label'=>'Create Productattrvalue', 'url'=>array('create')),
	array('label'=>'Manage Productattrvalue', 'url'=>array('admin')),
);
?>

<h1>Productattrvalues</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
