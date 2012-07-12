<label><?php echo Yii::t('labels', 'Product attributes'); ?><br /></label>
<?php
foreach ($attrgrouplist as $attrGroup) {
		$groupAttrList = Attribute::model()->with('productcategories'/*, array('category_id' => $category_id)*/)->findAllByAttributes(
							array('group_id' => $attrGroup->id),
							'productcategories_productcategories.category_id = '.$category->id
							/*,
							$attr_query*/);
        echo CHtml::openTag('div', array('class' => 'attr'));
        echo "<h3>" . $attrGroup->name . "</h3>";

        foreach ($groupAttrList as $attr) {
                echo CHtml::label($attr->name, $attr->id);
                switch ($attr->type) {
    				case 1: //string
                        echo CHtml::textField(
                                'Product[attr][normal][' . $attr->id . ']', $model->findAttrValue($attr), array(
                                'size' => '50',
                        ));
                        break;
                	case 2: //boolean
                        echo CHtml::dropDownList(
                                'Product[attr][normal][' . $attr->id . ']', $model->findAttrValue($attr), array('0' => ' ', '1' => 'yes', '2' => 'no'));
    					break;
					case 3: //integer
						echo CHtml::textField(
                                'Product[attr][normal][' . $attr->id . ']', $model->findAttrValue($attr), array(
                                'size' => '10',
                        ));
                        break;
					case 4: //decimal
						echo CHtml::textField(
							'Product[attr][normal][' . $attr->id . ']', $model->findAttrValue($attr), array(
							'size' => '10',
						
                        ));
                        break;
					case 5: //string from list
                		echo CHtml::dropDownList(
                                'Product[attr][normal][' . $attr->id . ']', $model->findAttrValue($attr), CHtml::listData(
                                        Attrvaluelist::model()->findAllByAttributes(array(
                                                'attr_id' => $attr->id)), 'id', 'value') + array('0' => 'Own value...'));
                        echo CHtml::textField(
                                'Product[attr][new][' . $attr->id . ']', $model->findAttrValue($attr), array(
                                'size' => '50',
                        ));
                        break;
					case 6: //integer from list
                		echo CHtml::dropDownList(
                                'Product[attr][normal][' . $attr->id . ']', $model->findAttrValue($attr), CHtml::listData(
                                        Attrvaluelist::model()->findAllByAttributes(array(
                                                'attr_id' => $attr->id)), 'id', 'value') + array('0' => 'Own value...'));
                        echo CHtml::textField(
                                'Product[attr][new][' . $attr->id . ']', $model->findAttrValue($attr), array(
                                'size' => '10',
                        ));
                        break;
					case 7: //text
						$this->widget('application.extensions.tiny_mce.TinyMCE', array(
						    //'model'=>Productattrvalue::model()->findByAttributes(array('product_id' => $model->id, 'attr_id' => $attr->id)), //$model->findAttrValue($attr),
							'value' => $model->findAttrValue($attr),
							//'attribute'=>'value',
						    'name'=>'Product[attr][normal][' . $attr->id . ']',
							//'editorTemplate'=>'full',
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
						break;

                }
                //echo $form->labelEx($attr,'dimension');
                echo '<br>';
        }

        echo CHtml::closeTag('div');
}
?>
