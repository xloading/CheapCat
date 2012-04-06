<?php
/*$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Supplier', 'url'=>array('index')),
	array('label'=>'Create Supplier', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('supplier-grid', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>

<h1>Manage Suppliers</h1>

<?php
echo CHtml::link(
			Yii::t('labels','Add supplier'),
			CHtml::normalizeUrl(array('/admin/supplier/create')),
		  	array(
			    'class' => 'update-dialog-open-link',
			    'data-update-dialog-title' => Yii::t( 'labels', 'Add supplier' ),
			)
		);
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'supplier-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'address',
		'url',
		'description',
		'dateadded',
		/*
		'juridicname',
		'ogrn',
		'juridicaddress',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
