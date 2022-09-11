<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'okzN7GGpU2kbAD-aa4TsL8vgx47razAX',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
  //         'class' => 'yii\caching\ApcCache',
    //        'keyPrefix' => 'myappIndicadores',       // a unique cache key prefix
      //      'useApcu' => true,          //a partir de php 5.5 se soporta APCu
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
 
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
		   //Agregando nuevo CRUD =================================================   
		'generators' => [
					'crud' => [
						'class' => 'yii\gii\generators\crudARCA\Generator',
						'templates' => ['arcaCrud' => '@vendor/yiisoft/yii2-gii/src/generators/crudARCA/default']
					 ],
					'model' => [
						'class' => 'yii\gii\generators\modelARCA\Generator',
						'templates' => ['arcaModel' => '@vendor/yiisoft/yii2-gii/src/generators/modelARCA/default/']
					]
				],
    ];
}

return $config;
