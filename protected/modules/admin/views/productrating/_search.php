<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'productid'); ?>
		<?php echo $form->textField($model,'productid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'averating'); ?>
		<?php echo $form->textField($model,'averating',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ratecounter'); ?>
		<?php echo $form->textField($model,'ratecounter'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->