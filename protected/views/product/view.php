		<div class="row-fluid">
			<div class="span12">
				<?php
					echo CHtml::tag('h2');
					echo $model->name;
					echo CHtml::closeTag('h2');
				?>
				<div class="row-fluid">
					<div class="span3">
					<?php
						echo CHTML::image($model->largepic,'',array('alt'=>'$model->name','class'=>'thumbnail pull-left'));
					?>
					</div>
					<div class="span3">
					Средняя цена:
					<div class="avg_price"><?php echo $model->avg_price;?> руб.</div>
					<?php echo $model->min_price.' ... '.$model->max_price.' руб.'?><br>
					</div>
					<div class="span6">
					<?php $this->widget('application.components.SuppliersBriefList', array(
							  'product' => $model
							));
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="row-fluid">
		<div class="span2" id="sidebar-nav-fixed">
		</div>
		<div class="span7">
		<?php
		$attrValues = Productattrvalue::model()->findAllByAttributes(array('product_id' => $model->id));
    	foreach ($attrValues as $attrValue)	{
    		if($attrValue->attr->in_brief == 1) {
    			echo CHtml::tag('p');
    			echo '<b>'.$attrValue->attr->name.'</b>: '.$attrValue->value.' '.$attrValue->attr->dimension.'<br>';
    			echo CHtml::closeTag('p');
    		}
    	}
		echo $model->description;?>
		</div>
