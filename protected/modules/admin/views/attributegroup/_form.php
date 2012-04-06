<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'attributegroup-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model,'parent_id',CHTML::listData(Attributegroup::model()->findAll(), 'id', 'name'),
							array('size'=>1,
								'options' => array(Yii::app()->getRequest()->getQuery('parentid') => array('selected'=>'selected')))); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position'); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->