<?php
$this->breadcrumbs=array(
	'Attrvaluelists',
);

$this->menu=array(
	array('label'=>'Create Attrvaluelist', 'url'=>array('create')),
	array('label'=>'Manage Attrvaluelist', 'url'=>array('admin')),
);
?>

<h1>Attrvaluelists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
