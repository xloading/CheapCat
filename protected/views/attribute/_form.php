<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'attribute-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_id'); ?>
		<?php echo $form->textField($model,'group_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_brief'); ?>
		<?php echo $form->textField($model,'in_brief'); ?>
		<?php echo $form->error($model,'in_brief'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grouporder'); ?>
		<?php echo $form->textField($model,'grouporder'); ?>
		<?php echo $form->error($model,'grouporder'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dimension'); ?>
		<?php echo $form->textField($model,'dimension',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'dimension'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'brieforder'); ?>
		<?php echo $form->textField($model,'brieforder'); ?>
		<?php echo $form->error($model,'brieforder'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_filter'); ?>
		<?php echo $form->textField($model,'in_filter'); ?>
		<?php echo $form->error($model,'in_filter'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->