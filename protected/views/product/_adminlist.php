<h2>
	<?php echo $model->name; ?>
	<?php if ($model->id <> 0) {
			echo CHtml::link(
				Yii::t('labels','Edit category'),
				array('productcategory/update', 'id'=>$model->id),
			  	array(
				    'class' => 'update-dialog-open-link',
				    'data-update-dialog-title' => Yii::t( 'labels', 'Edit category' ),
				)
			);
			echo '&nbsp;';
			echo CHtml::link(
				Yii::t('labels','Delete category'),
				array('productcategory/delete', 'id'=>$model->id),
			  	array(
				    'class' => 'update-dialog-open-link',
				    'data-update-dialog-title' => Yii::t( 'labels', 'Delete category' ),
				)
			);
	}
	?>
	<br>
	<?php
	echo CHtml::link(
				Yii::t('labels','Add product'),
				CHtml::normalizeUrl(array('/product/create','categoryid'=>$model->id)),
			  	array(
				    'class' => 'update-dialog-open-link',
				    'data-update-dialog-title' => Yii::t( 'labels', 'Add product' ),
				)
			);
	?>
	<br>
	<?php
	echo CHtml::link(
				Yii::t('labels','Add category'),
				CHtml::normalizeUrl(array('/productcategory/create','parentid'=>$model->id)),
			  	array(
				    'class' => 'update-dialog-open-link',
				    'data-update-dialog-title' => Yii::t( 'labels', 'Add category' ),
				)
			);
	?>
</h2>
<?php
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
$dataProvider=new CActiveDataProvider('Product',array(   
                'criteria'=>Array(
                    'select'    =>'t.id,t.name,t.description,t.smallpic,t.largepic,brand.name',
                    'with' => array('brand'),
					//'join'      =>' JOIN  `brand` ON  `t`.`brand_id` =  `brand`.`id`',
					'condition' => 't.categoryid = IFNULL('.$model->id.',0)',
                    ),
                )
        );
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$products,
	'columns'=>array(
		'id',
		'name',
		//'category.name',
		'description',
		'brand.name',
		array('type'=>'image',
			'name' => 'Small Picture',
			'value' => '$data->smallpic',
        	'headerHtmlOptions'=>array('width'=>'100px'),
            ),
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
		            "/product/update",
		            array( "id" => $data->primaryKey ) )',
		          'options' => array(
		            'data-update-dialog-title' => Yii::t( 'labels', 'Update product' ),
					//'class' => 'update-dialog-open-link',
		          ),
		        ),
		        // View button
		        'view' => array(
		          'click' => 'updateDialogOpen',
		          'url' => 'Yii::app()->createUrl(
		            "/product/view",
		            array( "id" => $data->primaryKey ) )',
		          'options' => array(
		            'data-update-dialog-title' => Yii::t( 'labels', 'Preview product' ),
		          ),
		        ),
		),
	),
)));
/*<?php foreach($products as $product): ?>
<div class="product" id="c<?php echo $product->id; ?>">

	<div class="productname">
		<?php echo $product->name; ?>
	</div>

</div>
<?php endforeach; ?>*/

?>