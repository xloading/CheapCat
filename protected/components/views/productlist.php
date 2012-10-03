<?php

	foreach($this->products as $product) {
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
	}
?>