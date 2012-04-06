<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productcategory-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'parentid'); ?>
		<?php echo $form->dropDownList($model,'parentid',CHTML::listData(Productcategory::model()->findAll(), 'id', 'name'),
							array('size'=>1,
								'options' => array(Yii::app()->getRequest()->getQuery('parentid') => array('selected'=>'selected')))); ?>
		<?php echo $form->error($model,'parentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'smallpic'); ?>
		<?php echo CHtml::activeFileField($model, 'smallpic'); ?>
		<?php echo $form->error($model,'smallpic'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'inherit_attrs_from_parent'); ?>
		<?php echo $form->checkBox($model, 'inherit_attrs_from_parent',array('value' => '1')); ?>
		<?php echo $form->error($model,'inherit_attrs_from_parent'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->