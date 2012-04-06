<?php
$this->breadcrumbs=array(
	'Productfeedbacks',
);

$this->menu=array(
	array('label'=>'Create Productfeedback', 'url'=>array('create')),
	array('label'=>'Manage Productfeedback', 'url'=>array('admin')),
);
?>

<h1>Productfeedbacks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
