		<div class="span12">
			<div class="span3">
			<?php
					echo CHtml::tag('h2');
					echo $model->name;
					echo CHtml::closeTag('h2');
					echo CHTML::image($model->largepic,'',array('alt'=>'$model->name','class'=>'thumbnail pull-left'));
			?>
			</div>
			<div class="span4">
			Средняя цена:
			<div class="avg_price"><?php echo $model->avg_price;?> руб.</div>
			<?php echo $model->min_price.' ... '.$model->max_price.' руб.'?><br>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="span3">
		</div>
		<div class="span5">
		<?php echo $model->description;?>
		</div>
	</div>
