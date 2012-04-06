<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'categoryid'); ?>
		<?php
		if (isset($model->id)) $id = $model->id; else $id = '0';
		echo $form->dropDownList($model,'categoryid',CHTML::listData(Productcategory::model()->findAll(), 'id', 'name'),
							array('size'=>1,
								'options' => array(Yii::app()->getRequest()->getQuery('categoryid') => array('selected'=>'selected')),
								'encode' => false,
								'ajax' => array(
                                		'type' => 'POST',
                                        'url' => $this->createUrl('product/attrlist'),
                                        'data' => 'js:{"id":' . $id . ', "categoryid":this.value}',
                                        'success' => 'function(html){
                                        $("#product-attrs").html(html);
                                }'),
								'id' => 'Product_categoryid-'.uniqid())); ?>
		<?php echo $form->error($model,'categoryid'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'brand_id'); ?>
		<?php echo $form->dropDownList($model,'brand_id',CHTML::listData(Brand::model()->findAll(), 'id', 'name')/*,
							array('size'=>1,
								'options' => array(Yii::app()->getRequest()->getQuery('brandid') => array('selected'=>'selected')))*/); ?>
		<?php echo $form->error($model,'brand_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php $this->widget('application.extensions.tiny_mce.TinyMCE', array(
		    'model'=>$model,
		    'attribute'=>'description',
		    'editorOptions'=>array(
		        'language'=>'ru',
		        'width'=>'600px',
		        'height'=>'150px',
		    ),
		));?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php 
		if (!isset($model->smallpic) || trim($model->smallpic)==='')	{
			$this->widget('ext.EAjaxUpload.EAjaxUpload',
                 array(
                       'id'=>'uploadFile',
                       'config'=>array(
                                       'action'=>CHtml::normalizeUrl(array('/product/uploadimage')),
                                       'allowedExtensions'=>array("jpg"),//array("jpg","jpeg","gif","exe","mov" and etc...
                                       'sizeLimit'=>1*1024*1024,// maximum file size in bytes
                                       //'minSizeLimit'=>1*1024*1024,// minimum file size in bytes
                                       'onComplete'=>'js:function(id, fileName, responseJSON){ if (responseJSON) {$("#Product_largepic").val(responseJSON.filename);} }',
                                       //'messages'=>array(
                                       //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                       //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                       //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                       //                  'emptyError'=>"{file} is empty, please select files again without it.",
                                       //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                       //                 ),
                                       //'showMessage'=>"js:function(message){ alert(message); }"
                                      )
                      ));
		}
		else	{
			?>
			<div id="thumbnail">
			<?php echo CHTML::link(CHTML::image($model->smallpic,'',array('id'=>'productImage')),$model->largepic,array('id'=>'hrefProductImage'));?>
			</div>
			<?php
			Yii::app()->clientScript->registerScript('showlargepic','jQuery.fn.center = function () {
        this.css("position","absolute");
        this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
        this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
        return this;
    }
 
    $(document).ready(function() {
        $("#thumbnail img").click(function(e){
 
            $("#background").css({"opacity" : "0.7"})
                            .fadeIn("slow");
 
            $("#large").html("<img src=\'"+$(this).parent().attr("href")+"\' alt=\'"+$(this).attr("alt")+"\' /><br/>"+$(this).attr("rel")+"")
                       .center()
                       .fadeIn("slow");
 
            return false;
        });
 
        $(document).keypress(function(e){
            if(e.keyCode==27){
                $("#background").fadeOut("slow");
                $("#large").fadeOut("slow");
            }
        });
 
        $("#background").click(function(){
            $("#background").fadeOut("slow");
            $("#large").fadeOut("slow");
        });
 
        $("#large").click(function(){
            $("#background").fadeOut("slow");
            $("#large").fadeOut("slow");
        });
 
    });', CClientScript::POS_READY);
			echo CHTML::button('Change Image',array('id'=>'changeProductImage'));
			Yii::app()->clientScript->registerScript('chngimg_click', "$('#changeProductImage').live('click',function () { $('#updateImage').attr('style','display: block;');});", CClientScript::POS_READY);
		?>
		<div id="updateImage" style="display: none;">
		<?php
		$this->widget('ext.EAjaxUpload.EAjaxUpload',
                 array(
                       'id'=>'updateFile',
                       'config'=>array(
                                       'action'=>CHtml::normalizeUrl(array('/product/updateimage')),
                                       'allowedExtensions'=>array("jpg"),//array("jpg","jpeg","gif","exe","mov" and etc...
                                       'sizeLimit'=>1*1024*1024,// maximum file size in bytes
                                       //'minSizeLimit'=>1*1024*1024,// minimum file size in bytes
                                       'onComplete'=>'js:function(id, fileName, responseJSON){ if (responseJSON) {$("#Product_largepic").val(responseJSON.largepic); $("#Product_smallpic").val(responseJSON.smallpic); $("#productImage").attr("src",responseJSON.smallpic); $("#hrefProductImage").attr("href",responseJSON.largepic);} }',
                                       //'messages'=>array(
                                       //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                       //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                       //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                       //                  'emptyError'=>"{file} is empty, please select files again without it.",
                                       //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                       //                 ),
                                       //'showMessage'=>"js:function(message){ alert(message); }"
                                      )
                      ));
		?>
		</div>
		<?php
		echo CHTML::activeHiddenField($model,'smallpic');
		}?>
		<?php //echo $form->labelEx($model,'uploadedFile'); ?>
		<?php echo CHTML::activeHiddenField($model,'largepic'); ?>
		<?php //echo $form->error($model,'uploadedFile'); ?>
	</div>
	
	<div class="row" id="product-attrs">
    <?php
    	$category_id = Yii::app()->getRequest()->getQuery('categoryid');
    	if(isset($category_id)) {
    		$model->category = Productcategory::model()->findByPk($category_id);
    	}
		if (isset($model->category))
		{
			$attrGroupList = array();
			if(($model->category->inherit_attrs_from_parent == 1) && ($model->category->id !== 0))	{
				$category = Productcategory::model()->findByPk($model->category->parentid);
				foreach($category->attrs as $attrList)
				{
					if(!in_array($attrList->group_id,$attrGroupList))
					{
						$attrGroupList[] = $attrList->group_id;
					}
				}
				$attrGroups = Attributegroup::model()->findAllByPk($attrGroupList);
				$this->renderPartial('attrs', array(
											'model' => $model,
											'attrgrouplist' => $attrGroups,
											'category' => $category
                                         ));
			}
			else {
				foreach($model->category->attrs as $attrList)
				{
					if(!in_array($attrList->group_id,$attrGroupList))
					{
						$attrGroupList[] = $attrList->group_id;
					}
				}
				$attrGroups = Attributegroup::model()->findAllByPk($attrGroupList);
				$this->renderPartial('attrs', array(
											'model' => $model,
											'attrgrouplist' => $attrGroups,
											'category' => $model->category
                                         ));
			}
			
		}
        ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->