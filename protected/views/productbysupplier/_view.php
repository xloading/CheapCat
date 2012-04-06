<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplierid')); ?>:</b>
	<?php echo CHtml::encode($data->supplierid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('productid')); ?>:</b>
	<?php echo CHtml::encode($data->productid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />


</div>