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
		<?php echo $form->dropDownList($model,'group_id',CHTML::listData(Attributegroup::model()->findAll(), 'id', 'name'),
							array('size'=>1,
								'options' => array(Yii::app()->getRequest()->getQuery('groupid') => array('selected'=>'selected')))); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->checkBox($model,'in_brief'); ?>
		<?php echo $form->labelEx($model,'in_brief'); ?>
		<?php echo $form->error($model,'in_brief'); ?>
	</div>
	<br>
	<div class="row">
		<p>
			<?php echo $form->labelEx($model,'type'); ?>
			<br>
			<?php echo $form->radioButtonList($model, 'type',
						array('1' => Yii::t('labels','string'), '2' => Yii::t('labels','boolean'),
							'3' => Yii::t('labels','integer'), '4' => Yii::t('labels','decimal'),
							'5' => Yii::t('labels','string from list'), '6' => Yii::t('labels','integer from list'),),
						array('template' => '{label}{input}', 'separator' => '<br>')); ?>
			<?php echo $form->error($model,'type'); ?>
		</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grouporder'); ?>
		<?php echo $form->textField($model,'grouporder',array('size'=>3)); ?>
		<?php echo $form->error($model,'grouporder'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dimension'); ?>
		<?php echo $form->textField($model,'dimension',array('size'=>12,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'dimension'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'brieforder'); ?>
		<?php echo $form->textField($model,'brieforder',array('size'=>3)); ?>
		<?php echo $form->error($model,'brieforder'); ?>
	</div>

	<div class="row">
		<?php echo $form->checkBox($model,'in_filter'); ?>
		<?php echo $form->labelEx($model,'in_filter'); ?>
		<?php echo $form->error($model,'in_filter'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->