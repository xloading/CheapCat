<?php
$this->breadcrumbs=array(
	'Supplierfeedbacks',
);

$this->menu=array(
	array('label'=>'Create Supplierfeedback', 'url'=>array('create')),
	array('label'=>'Manage Supplierfeedback', 'url'=>array('admin')),
);
?>

<h1>Supplierfeedbacks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
