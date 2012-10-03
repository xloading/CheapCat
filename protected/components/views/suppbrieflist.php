<div class="row-fluid">
	<div class="span12">
		<p><strong>Цены в интернет-магазинах:</strong></p>
			<?php
				foreach ($product->productbysuppliers as $productbysupplier) {
					echo CHtml::tag('div',array('class'=>'row-fluid'));
					echo CHtml::tag('div',array('class'=>'span5'));
					echo $productbysupplier->supplier->name;
					echo CHtml::closeTag('div');
					echo CHtml::tag('div',array('class'=>'span4'));
					//var_dump($productbysupplier->supplier->supplierrating->averating);
					$this->widget('CStarRating',array(
					    'name'=>'supprating-'.$productbysupplier->supplier->id,
					    'value'=>round($productbysupplier->supplier->supplierrating->averating,1),
					    'readOnly'=>true,
						'maxRating'=>5,
						'minRating'=>0.5,
						'ratingStepSize'=>0.5,
						//'starCount'=>5,
					));
					echo CHtml::closeTag('div');
					echo CHtml::tag('div',array('class'=>'span3'));
					echo $productbysupplier->price;
					echo CHtml::closeTag('div');
					echo CHtml::closeTag('div');
				}
			?>
		</div>
	</div>
</div>


<?php
	/*foreach($this->products as $product) {
		echo CHtml::tag('div',array('class'=>'row-fluid'));
		echo CHtml::tag('div',array('class'=>'span12'));
		echo CHtml::tag('div',array('class'=>'product_brief'));
		echo CHtml::tag('div',array('class'=>'span2 product_thumb'));
		echo CHtml::image($product->smallpic,$product->name,array('width'=>$product->img_width,'height'=>$product->img_height));
		echo CHtml::closeTag('div');
		echo CHtml::tag('div',array('class'=>'span10'));
    	echo CHtml::link($product->name,'/product-'.$product->slug);
    	echo CHtml::tag('p');
    	$attrValues = Productattrvalue::model()->findAllByAttributes(array('product_id' => $product->id));
    	foreach ($attrValues as $attrValue)	{
    		if($attrValue->attr->in_brief == 1) {
    			echo $attrValue->attr->name.': '.$attrValue->value.' '.$attrValue->attr->dimension.'<br>';
    		}
    	}
    	echo $product->min_price.' .. '.$product->max_price.' руб.';
    	echo CHtml::closeTag('p');
    	echo CHtml::closeTag('div');
    	echo CHtml::closeTag('div');
    	echo CHtml::closeTag('div');
    	echo CHtml::closeTag('div');
	}*/
?>