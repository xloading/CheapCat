<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
	<meta name="MSSmartTagsPreventParsing" content="true"/>
	<meta name="Description" content="Система поиска и подбора различных товаров. Здесь можно выбрать товар по параметрам, ознакомиться с отзывами пользователей, сравнить цены интернет-магазинов и определиться с местом покупки."/>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<!-- Le styles -->
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/bootstrap-responsive.css" type="text/css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/frontend.css" type="text/css" rel="stylesheet">
</head>

<body>
<div class="container-fluid fill">
		<?php $this->widget('bootstrap.widgets.TbNavbar', array(
		    'type'=>'inverse', // null or 'inverse'
		    'brand'=>'StroykaPrices',
		    'brandUrl'=>'http://www.stroyka.ru',
		    'collapse'=>true, // requires bootstrap-responsive.css
		    'items'=>array(
		        array(
		            'class'=>'bootstrap.widgets.TbButton',
					'buttonType' => 'ajaxLink',
		            'htmlOptions'=>array('class'=>'pull-right','data-toggle'=>'modal','data-target'=>'#loginModal',),
					//'url'=>'/user/login/login',
					'label' => Yii::t('labels','Login'),
				),
		    ),
		)); ?>
	<div class="row-fluid contentwrapper">
		<div class="span2" id="logo">
		</div>
		<div class="span8">
			<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			    'id'=>'searchForm',
			    'type'=>'search',
			    'htmlOptions'=>array('class'=>'well form-search'),
			)); ?>
			<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			    //'model'=>$model,
			    //'attribute'=>'name',
			    'id'=>'product_query',
			    'name'=>'product_query',
			    'source'=>$this->createUrl('product/suggestProduct'),
			    'htmlOptions'=>array(
					'type'=>'text',
					'class'=>'input-search',
			    ),
			));
			?>
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type' => 'primary', 'label'=>'Найти')); ?>
			 
			<?php $this->endWidget(); ?>
		</div>
		<div class="span2">
		</div>
	</div>
	<div class="row-fluid contentwrapper">
		<div class="span2" id="sidebar-nav-fixed">
		<?php
		/*if(Yii::app()->user->isGuest && (!isset($this->module)&& $this->action->id == 'index'))
		{
			$this->widget('application.modules.user.components.LoginWidget');
		}*/
		$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'loginModal')); ?>
 
		<div class="modal-header">
		    <a class="close" data-dismiss="modal">&times;</a>
		    <h4><?php echo Yii::t('labels','Login form')?></h4>
		</div>
		 
		<div class="modal-body">
		    <p><?php $this->widget('application.modules.user.components.LoginWidget');?></p>
		</div>
		 
		<?php $this->endWidget(); ?>
		</div>
		<div class="span8">
			<div class="row-fluid">
			<?php echo $content; ?>
			</div>
		</div>
		<div class="span2">
		</div>
	</div>
</div>
</body>
</html>