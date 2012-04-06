<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productbysupplier-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'supplierid',array("value" => Yii::app()->getRequest()->getQuery('supplierid'))); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'categoryid'); ?>
		<?php
		if(isset($model->productid)){
			$categoryId = Product::model()->findByPk($model->productid)->categoryid;
		}
		else
			$categoryId = 0;
		echo $form->dropDownList(new Product,'categoryid',CHTML::listData(Productcategory::model()->findAll(), 'id', 'name'),
							array('size'=>1,
								'options' => array($categoryId => array('selected'=>'selected')),
								'encode' => false,
								'ajax' => array(
                                		'type' => 'POST',
                                        'url' => $this->createUrl('product/productsbycategorylist'),
                                        'data' => 'js:{"categoryid":this.value}',
                                        'success' => 'function(html){
                                        $("#category-products").html(html);
                                }'),
								'id' => 'Productbysupplier_categoryid-'.uniqid())); ?>
		<?php echo $form->error($model,'categoryid'); ?>
	</div>

	<div class="row" id="category-products">
		<?php
		if(isset($model->productid)){
			echo $form->dropDownList($model,'productid',CHTML::listData(Product::model()->findAllByAttributes(array('categoryid' => $category->id)), 'id', 'name'),
							array('size'=>1,
							'options' => array($model->productid => array('selected'=>'selected'))));
		}
		?>
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