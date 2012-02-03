<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplierid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->supplierid), array('view', 'id'=>$data->supplierid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('averating')); ?>:</b>
	<?php echo CHtml::encode($data->averating); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ratecounter')); ?>:</b>
	<?php echo CHtml::encode($data->ratecounter); ?>
	<br />


</div>