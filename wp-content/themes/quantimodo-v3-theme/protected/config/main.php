<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Quantimodo. Perfect your life!',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',

		// giix components 
		'ext.giix-components.*', 
		
		//for hybridauth
		'application.modules.hybridauth.controllers.*',

		// YUM
		'application.modules.user.models.*',

	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'tnny64',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('180.151.36.171','127.0.0.1','::1'),
			'generatorPaths' => array(
				'ext.giix-core', // giix generators
			), 
		),
		
		'hybridauth' => array(
            'baseUrl' => 'http://'. $_SERVER['SERVER_NAME'] . '/hybridauth',
			// 'urlFormat'=>'path',
            'withYiiUser' => false, // Set to true if using yii-user
            "providers" => array ( 
                "Google" => array ( 
                    "enabled" => true,
                    "keys"    => array ( "id" => "973261775321.apps.googleusercontent.com", "secret" => "BHVSIS9mvQMrsB3nldfjYzDJ" ),
					"scope"   => "https://www.googleapis.com/auth/userinfo.profile " .
								 "https://www.googleapis.com/auth/userinfo.email", // optional
                ),
				
                "Facebook" => array ( 
                    "enabled" => true,
                    "keys"    => array ( "id" => "436314759756101", "secret" => "6e5f87537edaaeaacffc920c2a38487c" ),
                    "scope"   => "email", 
                    "display" => "popup" 
                ),
  
                "Twitter" => array ( 
                    "enabled" => true,
                    "keys"    => array ( "key" => "Hv52gj36aYsCE3uG1uTxQ", "secret" => "FbDelhsmxWDQjaKWSO3tpHCXQ4CqtqRP6WtZHf7ydU" ) 
                ),
 
                "Yahoo" => array ( 
                    "enabled" => true,
                    "keys"    => array ( "key" => "dj0yJmk9TWJlNWRxRmp5bWV0JmQ9WVdrOU9YRlpRVVJuTjJzbWNHbzlNakEzT1RRMk9URTJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD02ZA--", "secret" => "cc162dc9be71c997d80ca5d765315fee0127a4c9" ) 
                ),
 
                "OpenID" => array (
                    "enabled" => true,
					"openid_identifier"	=>	"https://openid.stackexchange.com/",
					"openid-identity"	=>	"https://openid.stackexchange.com/",
                ),
            ),
			// to enable logging, set 'debug_mode' to true, then provide here a path of a writable file 
			// "debug_mode" => true, 
			// "debug_file" => "/home/tony/logs/test.log", 
        ),
		
		//YUM
		'user' => array(
			'debug' => false,
			'userTable' => 'user',
			'translationTable' => 'translation',
			'profileTable' => 'profile',
		),
		'usergroup' => array(
			'usergroupTable' => 'usergroup',
			'usergroupMessageTable' => 'user_group_message',
		),
		'avatar' => array(
				
		),
		'registration'	=> array (
			// 'registrationEmail'	=>	'quantimodo@azure18.cloudapp.net',
			// 'recoveryEmail'	=>	'quantimodo@azure18.cloudapp.net',
		),
		'membership' => array(
			'membershipTable' => 'membership',
			'paymentTable' => 'payment',
		),
		'friendship' => array(
			'friendshipTable' => 'friendship',
		),
		'profile' => array(
			'privacySettingTable' => 'privacysetting',
			'profileFieldTable' => 'profile_field',
			'profileTable' => 'profile',
			'profileCommentTable' => 'profile_comment',
			'profileVisitTable' => 'profile_visit',
		),
		'role' => array(
			'roleTable' => 'role',
			'userRoleTable' => 'user_role',
			'actionTable' => 'action',
			'permissionTable' => 'permission',
		),
		'message' => array(
			'messageTable' => 'message',
			'adminEmail' => 'quantimodo@quantimodo.com'
		),
	),

	// application components
	'components'=>array(
		// Dummy cache
		'cache' => array('class' => 'system.caching.CDummyCache'),
		// YUM
		'user'=>array(
			'class' => 'application.modules.user.components.YumWebUser',
			'allowAutoLogin'=>true,
			'loginUrl' => array('//user/user/login'),
		),
		// uncomment the following to enable URLs in path-format
		//*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		*/
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yii_1',
			'emulatePrepare' => true,
			'username' => 'DB_user1',
			'password' => 'tony17',
			'charset' => 'utf8',
			'tablePrefix' => '',
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
				// array(
                    // 'class' => 'ext.phpconsole.PhpConsoleYiiExtension',
                    // 'handleErrors' => true,
                    // 'handleExceptions' => false,
                    // 'basePathToStrip' => dirname($_SERVER['DOCUMENT_ROOT'])
                // )
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['adminEmail']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'quantimodo@quantimodo.com',
	),
);