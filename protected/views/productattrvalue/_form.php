<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productattrvalue-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attr_id'); ?>
		<?php echo $form->textField($model,'attr_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'attr_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attrlistvalue_id'); ?>
		<?php echo $form->textField($model,'attrlistvalue_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'attrlistvalue_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textField($model,'value',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->