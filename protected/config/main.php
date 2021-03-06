<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

require_once( dirname(__FILE__) . '/../helpers/common.php');
require_once( dirname(__FILE__) . '/../helpers/strings.php');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Стройка и Цены',
	'language'=>'ru',

	/*'aliases' => array(
		'lily' => 'application.modules.lily',
	),*/
	// preloading 'log' component
	'preload'=>array('log','bootstrap',),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.srbac.controllers.*',
		'application.modules.srbac.components.SBaseController',
		'application.modules.user.*',
		'application.modules.user.models.*',
        'application.modules.user.components.*',
		'ext.editMe.helpers.ExtEditMeHelper',
		'ext.eoauth.*',
		'ext.eoauth.lib.*',
		'ext.lightopenid.*',
		'ext.eauth.*',
		'ext.eauth.services.*',
		'ext.eauth.custom_services.CustomGoogleService',
		'ext.eauth.custom_services.CustomVKService',
		'ext.eauth.custom_services.CustomFBService',
		'ext.eauth.custom_services.CustomTwitterService',
		'ext.yii-mail.YiiMailMessage',
		'ext.filters.setReturnUrl.ESetReturnUrlFilter',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'321093',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
				'bootstrap.gii',
			),
		),
		'shop' => array( 'debug' => 'true'),
		'user' => array(
			//'tableUsers' => 'users',
			),
		'srbac' => array(
			'userclass'=>'User', //default: User
			'userid'=>'id', //default: userid
			'username'=>'username', //default:username
			'delimeter'=>'@', //default:-
			'debug'=>false, //default :false
			'pageSize'=>10, // default : 15
			'superUser' =>'Authorizer', //default: Authorizer
			'css'=>'srbac.css', //default: srbac.css
			'layout'=>
			'application.views.layouts.main', //default: application.views.layouts.main,
			//must be an existing alias
			'notAuthorizedView'=> 'srbac.views.authitem.unauthorized', // default:
			//srbac.views.authitem.unauthorized, must be an existing alias
			'alwaysAllowed'=>array( //default: array()
			'SiteLogin','SiteLogout','SiteIndex','SiteAdmin',
			'SiteError', 'SiteContact'),
			'userActions'=>array('Show','View','List'), //default: array()
			'listBoxNumberOfLines' => 15, //default : 10 'imagesPath' => 'srbac.images', // default: srbac.images 'imagesPack'=>'noia', //default: noia 'iconText'=>true, // default : false 'header'=>'srbac.views.authitem.header', //default : srbac.views.authitem.header,
			//must be an existing alias 'footer'=>'srbac.views.authitem.footer', //default: srbac.views.authitem.footer,
			//must be an existing alias 'showHeader'=>true, // default: false 'showFooter'=>true, // default: false
			'alwaysAllowedPath'=>'srbac.components', // default: srbac.components
			// must be an existing alias 
			),
		'admin',
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => array('/login'),
		),
		/*'lilyModuleLoader' => array(
			'class' => 'lily.LilyModuleLoader',
		),*/
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				/*'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',*/
				'login/<service:(vkontakte|google)>*'=>'user/login/login',
				'login'=>'user/login/login', // /<service:(vkontakte|google)
				'user/<controller:\w+>/<action:\w+>/<service:\w+>'=>'user/<controller>/<action>',
				'category-<slug:.*>' => 'productcategory/view',
				'product-<slug:.*>' => 'product/view',
			),
			'showScriptName' => FALSE,
		),
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=stroykaprices',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix'=>'tbl_',
			'enableProfiling' => true,
			'enableParamLogging' => true,
		),
		'authManager'=>array(
			// Path to SDbAuthManager in srbac module if you want to use case insensitive
			//access checking (or CDbAuthManager for case sensitive access checking)
			'class'=>'application.modules.srbac.components.SDbAuthManager',
			// The database component used
			'connectionID'=>'db',
			// The itemTable name (default:authitem)
			//'itemTable'=>'items',
			// The assignmentTable name (default:authassignment)
			//'assignmentTable'=>'assignments',
			// The itemChildTable name (default:authitemchild)
			//'itemChildTable'=>'itemchildren',
			),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				/*array(
					'class'=>'CWebLogRoute',
					'categories' => 'system.db.CDbCommand',
				),*/
				// -- CProfileLogRoute -------------------------------
                array(
                    'class'=>'CProfileLogRoute',
                    'levels'=>'profile',
                    //'enabled'=>true,
                ),
                // -------------------------------------------------------
                /*array(
	                'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
	                'ipFilters'=>array('127.0.0.1','192.168.1.215'),
	            ),*/
			),
		),
		'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'ImageMagick',
            // ImageMagick setup path
            'params'=>array('directory'=>'C:\imagemagick'),
        ),
        // enables theme based JQueryUI's
        'widgetFactory' => array(
            'widgets' => array(
                'CJuiAutoComplete' => array(
                    'themeUrl' => '/css/jqueryui',
                    'theme' => 'redmond',
                ),
                'CJuiDialog' => array(
                    'themeUrl' => '/css/jqueryui',
                    'theme' => 'redmond',
                ),
                'CJuiDatePicker' => array(
                    'themeUrl' => '/css/jqueryui',
                    'theme' => 'redmond',
                ),
            )
		),
		'cache' => array(
				'class' => 'CMemCache',
				//'class' => 'ext.redis.CRedisCache',
				//'useMemcached'=>true,
				'servers' => array(
					array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 60),
				),
//				'class' => 'system.caching.CDummyCache',
		),
		'session' => array(
			'class' => 'system.web.CDBHttpSession',
			'connectionID' => 'db',
			'sessionTableName' => 'sessions'
		),
		'loid' => array(
				//alias to dir, where you unpacked extension
				'class' => 'application.extensions.lightopenid.loid',
		),
		'eauth' => array(
				'class' => 'ext.eauth.EAuth',
				'popup' => true, // Использовать всплывающее окно вместо перенаправления на сайт провайдера
				'services' => array( // Вы можете настроить список провайдеров и переопределить их классы
						/*'google' => array(
								'class' => 'GoogleOpenIDService',
						),
						'yandex' => array(
								'class' => 'YandexOpenIDService',
						),
						'twitter' => array(
								// регистрация приложения: https://dev.twitter.com/apps/new
								'class' => 'TwitterOAuthService',
								'key' => '...',
								'secret' => '...',
						),*/
						'google_oauth' => array(
								// регистрация приложения: https://code.google.com/apis/console/
								'class' => 'GoogleOAuthService',
								'client_id' => '45019214517',
								'client_secret' => 'tGgsuH2eU08SykYzlT7WSFL8',
								'title' => 'Google (OAuth)',
						),
						/*'facebook' => array(
								// регистрация приложения: https://developers.facebook.com/apps/
								'class' => 'FacebookOAuthService',
								'client_id' => '...',
								'client_secret' => '...',
						),
						'linkedin' => array(
								// регистрация приложения: https://www.linkedin.com/secure/developer
								'class' => 'LinkedinOAuthService',
								'key' => '...',
								'secret' => '...',
						),
						'github' => array(
								// регистрация приложения: https://github.com/settings/applications
								'class' => 'GitHubOAuthService',
								'client_id' => '...',
								'client_secret' => '...',
						),
						'live' => array(
								// регистрация приложения: https://manage.dev.live.com/Applications/Index
								'class' => 'LiveOAuthService',
								'client_id' => '...',
								'client_secret' => '...',
						),*/
						'vkontakte' => array(
								// регистрация приложения: http://vkontakte.ru/editapp?act=create&site=1
								'class' => 'VKontakteOAuthService',
								'client_id' => '3034717',
								'client_secret' => 'DEVvb5zigpWVtILsv0gQ',
						),
						/*'mailru' => array(
								// регистрация приложения: http://api.mail.ru/sites/my/add
								'class' => 'MailruOAuthService',
								'client_id' => '...',
								'client_secret' => '...',
						),
						'moikrug' => array(
								// регистрация приложения: https://oauth.yandex.ru/client/my
								'class' => 'MoikrugOAuthService',
								'client_id' => '...',
								'client_secret' => '...',
						),
						'odnoklassniki' => array(
								// регистрация приложения: http://www.odnoklassniki.ru/dk?st.cmd=appsInfoMyDevList&st._aid=Apps_Info_MyDev
								'class' => 'OdnoklassnikiOAuthService',
								'client_id' => '...',
								'client_public' => '...',
								'client_secret' => '...',
								'title' => 'Однокл.',
						),*/
				),
		),
		'mail' => array(
			'class' => 'ext.yii-mail.YiiMail',
		),
		'bootstrap'=>array(
			'class'=>'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'xloading@mail.ru',
	),
);