<?php
if ($breadcrumb) {
	$this->breadcrumbs=array(
		$breadcrumb,
	);
}
?>
 
<h1><?php echo CHtml::encode($messageTitle); ?></h1>

<div class="row">
    <p><?php echo CHtml::encode($messageText); ?></p>
</div>