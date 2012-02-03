<?php
$this->breadcrumbs=array(
	'Brands'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Brand', 'url'=>array('index')),
	array('label'=>'Create Brand', 'url'=>array('create')),
);
?>

<?php
$this->widget( 'application.extensions.EUpdateDialog.EUpdateDialog',
	array(
		'dialogOptions' => array(
	    	'width' => 550,
		),
		'options' => array(
			//'categoryDivUrl' => CHtml::normalizeUrl(array('/productcategory/admin')),
			//'callback' => 'js:function() {if(typeof $.fn.yiiGridView != "undefined") { $.fn.yiiGridView.update("product-grid");}}'
		)
	)
);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'brand-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array(
			'class'=>'CButtonColumn',
			'buttons' => array(
		        // Delete button
		        /*'delete' => array(
		          'click' => 'updateDialogOpen',
		          'url' => 'Yii::app()->createUrl(
		            "/product/delete",
		            array( "id" => $data->primaryKey ) )',
		          'options' => array(
		            'data-update-dialog-title' => Yii::t( 'app', 'Delete confirmation' ),
		          ),
		        ),*/
		        // Update button
		        'update' => array(
		          'click' => 'updateDialogOpen',
				  'url' => 'Yii::app()->createUrl(
		            "/brand/update",
		            array( "id" => $data->primaryKey ) )',
		          'options' => array(
		            'data-update-dialog-title' => Yii::t( 'app', 'Update brand' ),
					//'class' => 'update-dialog-open-link',
		          ),
		        ),
			),
		),
	),
)); ?>
