<?php
echo CHtml::activeDropDownList(new Productbysupplier,'productid',CHTML::listData(Product::model()->findAllByAttributes(array('categoryid' => $category->id)), 'id', 'name'),
							array('size'=>1));
?>