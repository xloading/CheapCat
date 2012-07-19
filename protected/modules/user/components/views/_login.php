<?php echo CHtml::beginForm('','post',array('class'=>'well')); ?>
	<div class="centered-text">
	<?php echo CHtml::errorSummary($model); ?>
	<?php echo CHtml::activeTextField($model,'username',array('class'=>'span6','placeholder'=>UserModule::t("username"))) ?>
	<?php echo CHtml::activePasswordField($model,'password',array('class'=>'span6','placeholder'=>UserModule::t("password"))) ?>
	<label class='checkbox'>
	<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
	<?php $modelLabels = $model->attributeLabels();
		echo $modelLabels['rememberMe']; ?> 
	</label>
	<?php echo CHtml::submitButton(UserModule::t("Login"),array('class'=>'btn')); ?>
	<span class='help-block'>
	Enter using
	</span>
	<?php 
	    $this->widget('ext.eauth.EAuthWidget', array('action' => 'login'));
	?>
	<p class="hint">
	<?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
	</p>
	</div>
<?php echo CHtml::endForm(); ?>
<!-- form -->


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>