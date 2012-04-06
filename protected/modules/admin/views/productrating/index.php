<?php
$this->breadcrumbs=array(
	'Productratings',
);

$this->menu=array(
	array('label'=>'Create Productrating', 'url'=>array('create')),
	array('label'=>'Manage Productrating', 'url'=>array('admin')),
);
?>

<h1>Productratings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
