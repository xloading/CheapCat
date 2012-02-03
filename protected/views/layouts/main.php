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
				array('label'=>'Home', 'url'=>array('/site/index'),'ajax' => False),
				array('label'=>Yii::t('menuItems','Products'), /*'url'=>array('/site/products'),*/ 'visible'=>UserModule::isAdmin(), 'items' => 
					array(
						array('label'=>Yii::t('menuItems','Products and Categories'), 'url'=>array('/productcategory/admin'), 'visible'=>UserModule::isAdmin()),
						array('label'=>Yii::t('menuItems','Brands'), 'url'=>array('/brand/admin'), 'visible'=>UserModule::isAdmin()),
						array('label'=>Yii::t('menuItems','Feedbacks'), 'url'=>array('/productfeedback/admin'), 'visible'=>UserModule::isAdmin()),
					),
					//'ajax' => False
				),
				array('label'=>Yii::t('menuItems','Suppliers'), /*'url'=>array('/site/suppliers'),*/ 'visible'=>UserModule::isAdmin(), 'items' => 
					array(
						array('label'=>Yii::t('menuItems','Suppliers'), 'url'=>array('/supplier/admin'), 'visible'=>UserModule::isAdmin()),
						array('label'=>Yii::t('menuItems','Feedbacks'), 'url'=>array('/supplierfeedback/admin'), 'visible'=>UserModule::isAdmin()),
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

	<?php echo $content; ?>

	<div id="footer">
		
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>