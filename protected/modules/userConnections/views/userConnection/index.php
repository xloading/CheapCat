<?php
$this->breadcrumbs=array(
	'User Connections',
);

$this->menu=array(
	array('label'=>'Create UserConnection', 'url'=>array('create')),
	array('label'=>'Manage UserConnection', 'url'=>array('admin')),
);
?>

<h1>User Connections</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
