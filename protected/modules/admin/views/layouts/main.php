<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" /> -->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->
	<?php $this->widget('ext.CMyAjaxMenu.CMyAjaxMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/admin'),'ajax' => False),
				array('label'=>Yii::t('menuItems','Products'), /*'url'=>array('/admin/productcategory/admin'), 'linkOptions' => array("data-pjax" => "#content"),*/ 'visible'=>UserModule::isAdmin(), 'items' => 
					array(
						array('label'=>Yii::t('menuItems','Products and Categories'), 'url'=>array('/admin/productcategory/admin'), /*'linkOptions' => array("data-ajax" => "true"),*/ 'visible'=>UserModule::isAdmin()),
						array('label'=>Yii::t('menuItems','Brands'), 'url'=>array('/admin/brand/admin'), /*'linkOptions' => array("data-ajax" => "true"), 'ajax' => False,*/ 'visible'=>UserModule::isAdmin()),
						array('label'=>Yii::t('menuItems','Attributes'), 'url'=>array('/admin/attributegroup/admin'), 'linkOptions' => array("data-ajax" => "true"), 'visible'=>UserModule::isAdmin()),
						array('label'=>Yii::t('menuItems','Categories and attributes'), 'url'=>array('/admin/productcategory/linkwithattributes'), 'linkOptions' => array("data-ajax" => "true"), 'visible'=>UserModule::isAdmin()),
						array('label'=>Yii::t('menuItems','Feedbacks'), 'url'=>array('/admin/productfeedback/admin'), 'linkOptions' => array("data-ajax" => "true"), 'visible'=>UserModule::isAdmin()),
					),
					//'ajax' => False
				),
				array('label'=>Yii::t('menuItems','Suppliers'), /*'url'=>array('/site/suppliers'),*/ 'visible'=>UserModule::isAdmin(), 'items' => 
					array(
						array('label'=>Yii::t('menuItems','Suppliers'), 'url'=>array('/admin/supplier/admin'), 'visible'=>UserModule::isAdmin()),
						array('label'=>Yii::t('menuItems','Products of suppliers'), 'url'=>array('/admin/supplier/adminproductsbysupplier'), 'visible'=>UserModule::isAdmin()),
						array('label'=>Yii::t('menuItems','Feedbacks'), 'url'=>array('/admin/supplierfeedback/admin'), 'visible'=>UserModule::isAdmin()),
					),
					//'ajax' => False
				),
				array('url'=>array('/srbac/authitem/frontpage'), 'label'=>'RBAC Administration', 'visible'=>UserModule::isAdmin()),
				//array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				//array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login"), 'visible'=>Yii::app()->user->isGuest,'ajax' => False),
				array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Register"), 'visible'=>Yii::app()->user->isGuest,'ajax' => False),
				array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Profile"), 'visible'=>!Yii::app()->user->isGuest,'ajax' => False),
				array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest,'ajax' => False),
			),
			//'style' => 'navbar',
			'activeCssClass' => 'active',
			'optionalIndex'=>true,
			  'ajax'=>array(
			      'update' => '#content',
			  ),
			  'randomID'=>true,
		)); ?><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php
	/*$this->widget( 'application.extensions.EUpdateDialog.EUpdateDialog',
		array(
			'dialogOptions' => array(
		    	'width' => 550,
			),
			'options' => array(
				'categoryDivUrl' => CHtml::normalizeUrl(array('/admin/attributegroup/admin')),
				//'callback' => 'js:function() {if(typeof $.fn.yiiGridView != "undefined") { $.fn.yiiGridView.update("product-grid");}}'
			)
		)
	);*/
	echo $content;
	?>

	<div id="footer">
		<?php $this->widget( 'application.extensions.EUpdateDialog.EUpdateDialog',
				array(
					'dialogOptions' => array(
				    	'width' => 800,
						'height' => 'auto',
						'position' => array(0,0)
					),
					'options' => array(
						'categoryDivUrl' => CHtml::normalizeUrl(array('/admin/productcategory/admin')),
						'attrgroupDivUrl' => CHtml::normalizeUrl(array('/admin/attributegroup/admin')),
						//'callback' => 'js:function() {if(typeof $.fn.yiiGridView != "undefined") { $.fn.yiiGridView.update("product-grid");}}'
					)
				)
			);
		?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>