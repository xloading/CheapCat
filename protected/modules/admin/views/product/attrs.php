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
                }
                //echo $form->labelEx($attr,'dimension');
                echo '<br>';
        }

        echo CHtml::closeTag('div');
}
?>
