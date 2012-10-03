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
			//'editorTemplate'=>'full',
			//'useSwitch'=>false,
			//'useCompression'=>false,
		    'editorOptions'=>array(
				'mode' =>'none',
		        'language'=>'ru',
		        'width'=>'600px',
		        'height'=>'150px',
				'plugins'=>'safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
		        'theme'=>'advanced',
		        'theme_advanced_buttons1'=>'save,newdocument,print,|,cut,copy,paste,pastetext,pasteword,|,search,replace,|,undo,redo,|,removeformat,cleanup,|,spellchecker,|,visualaid,visualchars,|,ltr,rtl,|,code,preview,fullscreen,|,help',
				'theme_advanced_buttons2'=>'formatselect,fontselect,fontsizeselect,|,forecolor,backcolor,|,bold,italic,underline,strikethrough,|,sub,sup',
				'theme_advanced_buttons3'=>'justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,hr,advhr,nonbreaking,pagebreak,blockquote,|,charmap,emotions,media,image,|,link,unlink,anchor,|,insertdate,inserttime',
				'theme_advanced_buttons4'=>'tablecontrols,|,insertlayer,moveforward,movebackward,absolute,|,styleprops,del,ins,attribs,|,template',
				'theme_advanced_toolbar_location'=>'top',
		        'theme_advanced_toolbar_align'=>'left',
		        'theme_advanced_statusbar_location'=>'bottom',
		        'theme_advanced_path'=>false,
		        'theme_advanced_resizing'=>false,
		        'theme_advanced_path_location'=>'none',
		        'force_br_newlines'=>true,
		        'force_p_newlines'=>false,
		        'forced_root_block'=>'',
		    ),
		));
		?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'largepic'); ?>
		<?php 
		if (!isset($model->smallpic) || trim($model->smallpic)==='')	{
			$this->widget('ext.EAjaxUpload.EAjaxUpload',
                 array(
                       'id'=>'uploadFile',
                       'config'=>array(
                                       'action'=>CHtml::normalizeUrl(array('/admin/product/uploadimage')),
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
                                       'action'=>CHtml::normalizeUrl(array('/admin/product/updateimage')),
                                       'allowedExtensions'=>array("jpg"),//array("jpg","jpeg","gif","exe","mov" and etc...
                                       'sizeLimit'=>1*1024*1024,// maximum file size in bytes
                                       //'minSizeLimit'=>1*1024*1024,// minimum file size in bytes
                                       'onComplete'=>'js:function(id, fileName, responseJSON){ if (responseJSON) {$("#Product_largepic").val(responseJSON.largepic); $("#Product_smallpic").val(responseJSON.smallpic); $("#productImage").attr("src",responseJSON.smallpic); $("#Product_img_width").val(responseJSON.img_width); $("#Product_img_height").val(responseJSON.img_height); $("#hrefProductImage").attr("href",responseJSON.largepic);} }',
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
		echo CHTML::activeHiddenField($model,'img_width');
		echo CHTML::activeHiddenField($model,'img_height');
		}?>
		<?php //echo $form->labelEx($model,'uploadedFile'); ?>
		<?php echo CHTML::activeHiddenField($model,'largepic'); ?>
		<?php //echo $form->error($model,'uploadedFile'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'manual'); ?>
		<?php 
		if (!isset($model->manual) || trim($model->manual)==='')	{
			$this->widget('ext.EAjaxUpload.EAjaxUpload',
                 array(
                       'id'=>'uploadManual',
                       'config'=>array(
                                       'action'=>CHtml::normalizeUrl(array('/admin/product/uploadmanual')),
                                       'allowedExtensions'=>array("pdf","doc","docx"),//array("jpg","jpeg","gif","exe","mov" and etc...
                                       'sizeLimit'=>10*1024*1024,// maximum file size in bytes
                                       //'minSizeLimit'=>1*1024*1024,// minimum file size in bytes
                                       'onComplete'=>'js:function(id, fileName, responseJSON){ if (responseJSON) {$("#Product_manual").val(responseJSON.filename);} }',
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
			<div id="manual">
			<?php echo CHTML::link('Manual','upload/'.$model->manual,array('id'=>'hrefProductManual'));?>
			</div>
			<?php 
			echo CHTML::button('Change Manual',array('id'=>'changeProductManual'));
			Yii::app()->clientScript->registerScript('chngman_click', "$('#changeProductManual').live('click',function () { $('#updateManual').attr('style','display: block;');});", CClientScript::POS_READY);
			?>
			<div id="updateManual" style="display: none;">
			<?php
			$this->widget('ext.EAjaxUpload.EAjaxUpload',
	                 array(
	                       'id'=>'updateManual',
	                       'config'=>array(
	                                       'action'=>CHtml::normalizeUrl(array('/admin/product/updatemanual')),
	                                       'allowedExtensions'=>array("pdf","doc","docx"),//array("jpg","jpeg","gif","exe","mov" and etc...
	                                       'sizeLimit'=>10*1024*1024,// maximum file size in bytes
	                                       //'minSizeLimit'=>1*1024*1024,// minimum file size in bytes
	                                       'onComplete'=>'js:function(id, fileName, responseJSON){ if (responseJSON) {$("#Product_manual").val(responseJSON.filename);} }',
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
		}
		echo CHTML::activeHiddenField($model,'manual');
		?>
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