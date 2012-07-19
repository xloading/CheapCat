<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
	<meta name="MSSmartTagsPreventParsing" content="true"/>
	<meta name="Description" content="Система поиска и подбора различных товаров. Здесь можно выбрать товар по параметрам, ознакомиться с отзывами пользователей, сравнить цены интернет-магазинов и определиться с местом покупки."/>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<!-- Le styles -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/frontend.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span3">
		</div>
		<div class="span7">
			<form class="well form-search">
			<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			    //'model'=>$model,
			    //'attribute'=>'name',
			    'id'=>'product_query',
			    'name'=>'product_query',
			    'source'=>$this->createUrl('product/suggestProduct'),
			    'htmlOptions'=>array(
					'type'=>'text',
					'class'=>'input-search search-query',
			    ),
			));
			?>
			<button type="submit" class="btn btn-primary">Найти</button>
			</form>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span3">
		<?php 
		if(Yii::app()->user->isGuest)
		{
			$this->widget('application.modules.user.components.LoginWidget');
		}
		?>
		</div>
		<div class="span7">
			<div class="row-fluid">
			<?php echo $content; ?>
			</div>
		</div>
	</div>
</td>
<td class="settings"></td>
</tr>
</table>
</body>
</html>