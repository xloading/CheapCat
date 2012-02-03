<?php
$this->breadcrumbs=array(
	'Productfeedbacks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Productfeedback', 'url'=>array('index')),
	array('label'=>'Create Productfeedback', 'url'=>array('create')),
	array('label'=>'View Productfeedback', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Productfeedback', 'url'=>array('admin')),
);
?>

<h1>Update Productfeedback <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>