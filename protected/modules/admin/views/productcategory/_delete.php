<?php $form = $this->beginWidget( 'CActiveForm', array(
  'id' => 'location-delete-form',
  'enableAjaxValidation' => false,
  'focus' => '#confirmDelete',
)); ?>
 
<div class="buttons">
  <?php
  if (count($products) > 0)
  {
  	echo Yii::t('messages','The category you are going to delete contains products. What do you want to do with them?').'<br>';
  	echo CHtml::submitButton( Yii::t('labels','Delete with products'), array( 'name' => 'confirmDeleteWithProducts', 
    	'id' => 'confirmDelete')).'&nbsp;';
  	echo CHtml::submitButton( Yii::t('labels','Delete category and assign products to root'), array( 'name' => 'confirmDeleteWithoutProducts', 
    	'id' => 'confirmDeleteWithoutProducts')).'&nbsp;';
  }
  else
  {
	  echo CHtml::submitButton( Yii::t('labels','Confirm deletion'), array( 'name' => 'confirmDelete', 
	    'id' => 'confirmDelete' ) );
  }
  echo CHtml::submitButton( Yii::t('labels','Cancel deletion'), array( 'name' => 'denyDelete' ) ); 
  ?>
 
  <?php
  /* !!! Or you can use jQuery UI buttons, makes no difference !!!
  $this->widget( 'zii.widgets.jui.CJuiButton', array(
    'name' => 'confirmDelete',
    'caption' => 'Yes',
  ));
  $this->widget( 'zii.widgets.jui.CJuiButton', array(
    'name' => 'denyDelete',
    'caption' => 'No',
  ));*/
  ?>
</div>
 
<?php $this->endWidget(); ?>