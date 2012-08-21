<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email'); ?>
	<?php echo $form->error($model,'email'); ?>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password'); ?>
	<?php echo $form->error($model,'password'); ?>
	<p class="hint">
	<?php echo UserModule::t("Minimal password length 6 symbols."); ?>
	</p>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'password_repeat'); ?>
	<?php echo $form->passwordField($model,'password_repeat'); ?>
	<?php echo $form->error($model,'password_repeat'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Continue'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>