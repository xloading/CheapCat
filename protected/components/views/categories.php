<?php 
	$col_count = 0;
    foreach($this->categories as $main_category) {
    	$col_count++;
    	if ($col_count%3 == 1)	{
    		echo CHtml::tag('div',array('class'=>'row-fluid'));
    	}
    	echo CHtml::tag('div',array('class'=>'span4'));
    	echo CHtml::tag('ul');
    	echo CHtml::tag('li');
		echo CHtml::link($main_category->name,'/category-'.$main_category->slug, array('class'=>'main_categories'));
		if (!$main_category->isLeaf()) {
			$descendant_categories = $main_category->descendants()->findAll();
			$sum = 0;
			foreach ($descendant_categories as $descendant_category) {
				if ($descendant_category->isLeaf()) {
					$sum = $sum + Product::model()->count('categoryid=' . $descendant_category->id);
				}
			}
			echo "<span class='products_num'>(".$sum.")</span>";
		}
		echo CHtml::closeTag('li');
		$child_categories = $main_category->children()->findAll();
		if (count($child_categories) > 0) {
			echo CHtml::tag('li');
			foreach($child_categories as $child_category) {
				echo CHtml::link($child_category->name,'/category-'.$child_category->slug);
				echo '<span class="categories__separator">, </span>';
			}
			echo CHtml::closeTag('li');
		}
		echo CHtml::closeTag('ul');
		echo CHtml::closeTag('div');
    	if ($col_count%3 == 0)	{
    		echo CHtml::closeTag('div');
    	}
	}
?>