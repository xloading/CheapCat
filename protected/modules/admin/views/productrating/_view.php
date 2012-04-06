<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('productid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->productid), array('view', 'id'=>$data->productid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('averating')); ?>:</b>
	<?php echo CHtml::encode($data->averating); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ratecounter')); ?>:</b>
	<?php echo CHtml::encode($data->ratecounter); ?>
	<br />


</div>