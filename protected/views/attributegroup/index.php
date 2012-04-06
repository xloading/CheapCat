<?php
$this->breadcrumbs=array(
	'Attributegroups',
);

$this->menu=array(
	array('label'=>'Create Attributegroup', 'url'=>array('create')),
	array('label'=>'Manage Attributegroup', 'url'=>array('admin')),
);
?>

<h1>Attributegroups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
