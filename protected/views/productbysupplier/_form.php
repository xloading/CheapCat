<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productbysupplier-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'supplierid'); ?>
		<?php echo $form->textField($model,'supplierid'); ?>
		<?php echo $form->error($model,'supplierid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'productid'); ?>
		<?php echo $form->textField($model,'productid',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'productid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->