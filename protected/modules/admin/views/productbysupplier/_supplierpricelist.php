<h2>
	<?php echo $supplier->name; ?>
	<br>
	<?php
	echo CHtml::link(
				Yii::t('labels','Add new product to supplier\'s pricelist'),
				CHtml::normalizeUrl(array('/admin/productbysupplier/create','supplierid'=>$supplier->id)),
			  	array(
				    'class' => 'update-dialog-open-link',
				    'data-update-dialog-title' => Yii::t( 'labels', 'Add product' ),
				)
			);
	?>
	<br>
</h2>
<?php
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.jeditable.mini.js');
Yii::app()->clientScript->registerScript('price','
	$("b[class^=click-]").live("click", function () {
		$(this).editable("'.$this->createUrl('/admin/productbysupplier/updateprice').'", {
			submitdata : function (value,settings){
							return {"Productbysupplier[id]":$(this).attr("class").substr("6"),};
						},
	        indicator : "Saving...",
	        tooltip   : "Click to edit...",
	      	style  : "inherit",
	      	name : "Productbysupplier[price]"
	     });
	});
',CClientScript::POS_READY);
$dataProvider=new CActiveDataProvider('Productbysupplier',array(   
                'criteria'=>Array(
                    'select'    =>'id,category.name as category_name,product.name as product_name,t.price',
                    'with' => array('product','product.category'),
					//'join'      =>' JOIN  `productcategory` productcategory ON  `product`.`categoryid` =  `productcategory`.`id`',
					'condition' => 't.supplierid = IFNULL('.$supplier->id.',0)',
                    ),
                )
        );
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'productbysupplier-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$products,
	'columns'=>array(
		'product.category.name',
		'product.name',
		'price'=> array(
                'type'=>'raw',
                'value' => '"<b class=\'click-".$data->id."\'>".$data->price."</b>"',
                'header' => 'Price'
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
		            "/admin/productbysupplier/update",
		            array( "id" => $data->primaryKey ) )',
		          'options' => array(
		            'data-update-dialog-title' => Yii::t( 'labels', 'Update product price' ),
					'id' => 'btn-upd-'.uniqid(),
					//'class' => 'update-dialog-open-link',
		          ),
		        ),
		        // View button
		        /*'view' => array(
		          'click' => 'updateDialogOpen',
		          'url' => 'Yii::app()->createUrl(
		            "/admin/product/view",
		            array( "id" => $data->primaryKey ) )',
		          'options' => array(
		            'data-update-dialog-title' => Yii::t( 'labels', 'Preview product' ),
		        	'id' => 'btn-view-'.uniqid(),
		          ),
		        ),*/
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