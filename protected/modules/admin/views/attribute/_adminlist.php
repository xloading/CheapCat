<h2>
	<?php echo $model->name; ?>
	<?php if ($model->id <> 0) {
			echo CHtml::link(
				Yii::t('labels','Edit attribute group'),
				array('/admin/attributegroup/update', 'id'=>$model->id),
			  	array(
				    'class' => 'update-dialog-open-link',
				    'data-update-dialog-title' => Yii::t( 'labels', 'Edit attribute group' ),
				)
			);
			echo '&nbsp;';
			echo CHtml::link(
				Yii::t('labels','Delete attribute group'),
				array('/admin/attributegroup/delete', 'id'=>$model->id),
			  	array(
				    'class' => 'update-dialog-open-link',
				    'data-update-dialog-title' => Yii::t( 'labels', 'Delete attribute group' ),
				)
			);
	}
	?>
	<br>
	<?php
	echo CHtml::link(
				Yii::t('labels','Add attribute'),
				CHtml::normalizeUrl(array('/admin/attribute/create','groupid'=>$model->id)),
			  	array(
				    'class' => 'update-dialog-open-link',
				    'data-update-dialog-title' => Yii::t( 'labels', 'Add attribute' ),
				)
			);
	?>
	<br>
	<?php
	echo CHtml::link(
				Yii::t('labels','Add attribute group'),
				CHtml::normalizeUrl(array('/admin/attributegroup/create','parentid'=>$model->id)),
			  	array(
				    'class' => 'update-dialog-open-link',
				    'data-update-dialog-title' => Yii::t( 'labels', 'Add attribute group' ),
				)
			);
	?>
</h2>
<?php
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
$dataProvider=new CActiveDataProvider('Attribute',array(   
                'criteria'=>Array(
                    'select'    =>'t.id,t.name,t.in_brief,t.type',
                    //'with' => array('brand'),
					//'join'      =>' JOIN  `brand` ON  `t`.`brand_id` =  `brand`.`id`',
					'condition' => 't.group_id = IFNULL('.$model->id.',0)',
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
		array(
			'name' => 'in_brief',
			'filter' => array('1' => Yii::t('labels','Yes'), '0' => Yii::t('labels','No')),
			'value' => '$data->in_brief == 1 ? Yii::t("labels","Yes") : Yii::t("labels","No")',
			'header' => Yii::t('labels','In brief')
		),
		array(
			'name' => 'type',
			'filter' => array('1' => Yii::t('labels','string'), '2' => Yii::t('labels','boolean'), '3' => Yii::t('labels','integer'), '4' => Yii::t('labels','decimal')),
			'value' => '$data->GetType()'
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
		            "/admin/attribute/update",
		            array( "id" => $data->primaryKey ) )',
		          'options' => array(
		            'data-update-dialog-title' => Yii::t( 'labels', 'Update attribute' ),
					//'class' => 'update-dialog-open-link',
		          ),
		        ),
		        // View button
		        'view' => array(
		          'click' => 'updateDialogOpen',
		          'url' => 'Yii::app()->createUrl(
		            "/admin/attribute/view",
		            array( "id" => $data->primaryKey ) )',
		          'options' => array(
		            'data-update-dialog-title' => Yii::t( 'labels', 'Preview attribute' ),
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