<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group_id')); ?>:</b>
	<?php echo CHtml::encode($data->group_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_brief')); ?>:</b>
	<?php echo CHtml::encode($data->in_brief); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grouporder')); ?>:</b>
	<?php echo CHtml::encode($data->grouporder); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dimension')); ?>:</b>
	<?php echo CHtml::encode($data->dimension); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('brieforder')); ?>:</b>
	<?php echo CHtml::encode($data->brieforder); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_filter')); ?>:</b>
	<?php echo CHtml::encode($data->in_filter); ?>
	<br />

	*/ ?>

</div>