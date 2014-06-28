<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		/*		
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		), 
		*/
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yii_1',
			'emulatePrepare' => true,
			'username' => 'DB_user1',
			'password' => 'tony17',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
	'modules'=>array(),
);