<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productrating-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'productid'); ?>
		<?php echo $form->textField($model,'productid'); ?>
		<?php echo $form->error($model,'productid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'averating'); ?>
		<?php echo $form->textField($model,'averating',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'averating'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ratecounter'); ?>
		<?php echo $form->textField($model,'ratecounter'); ?>
		<?php echo $form->error($model,'ratecounter'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->