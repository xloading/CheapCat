<?php
$this->breadcrumbs=array(
	'Productcategories',
);

$this->menu=array(
	array('label'=>'Create Productcategory', 'url'=>array('create')),
	array('label'=>'Manage Productcategory', 'url'=>array('admin')),
);
?>

<h1>Productcategories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
