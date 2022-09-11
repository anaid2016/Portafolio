<?php
 
$db     = require(__DIR__ . '/../../config/db.php');
$params = require(__DIR__ . '/params.php');
 
$config = [
    'id' => 'basic',
    'timeZone' => 'America/Bogota',
    'name' => 'TimeTracker',
    // Need to get one level up:
    'basePath' => dirname(__DIR__).'/..',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // Enable JSON Input:
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                     // Create API log in the standard log dir
                     // But in file 'api.log':
                    'logFile' => '@app/runtime/logs/api.log',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                //['class' => 'yii\rest\UrlRule', 'controller' => 'v1/entry','pluralize' => false,'extraPatterns' => ['POST insertar' => 'insertar']],
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sfvcontadores','pluralize' => false,'extraPatterns' => ['POST insertar' => 'insertar']],
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sfvinversorhibrido','pluralize' => false,'extraPatterns' => ['POST insertar' => 'insertar']],
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sfvongrid','pluralize' => false,'extraPatterns' => ['POST insertar' => 'insertar']],
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sfvcontrolador','pluralize' => false,'extraPatterns' => ['POST insertar' => 'insertar']],
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sfvequipos','pluralize' => false,'extraPatterns' => ['POST search' => 'search']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sgelecturas','pluralize' => false,'extraPatterns' => ['POST search' => 'search']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sgelecturas','pluralize' => false,'extraPatterns' => ['OPTIONS search' => 'search']],
                
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sgelecturas','pluralize' => false,'extraPatterns' => ['POST searchmes' => 'searchmes']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sgelecturas','pluralize' => false,'extraPatterns' => ['OPTIONS searchmes' => 'searchmes']],
                
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sgelecturas','pluralize' => false,'extraPatterns' => ['POST insertar' => 'insertar']],
                
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sgelecturas','pluralize' => false,'extraPatterns' => ['OPTIONS searchuser' => 'searchuser']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sgelecturas','pluralize' => false,'extraPatterns' => ['POST searchuser' => 'searchuser']],
                
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sgelecturas','pluralize' => false,'extraPatterns' => ['POST searchgrafica' => 'searchgrafica']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sgelecturas','pluralize' => false,'extraPatterns' => ['OPTIONS searchgrafica' => 'searchgrafica']],
                
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sgelecturas','pluralize' => false,'extraPatterns' => ['POST searchmesgrafica' => 'searchmesgrafica']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sgelecturas','pluralize' => false,'extraPatterns' => ['OPTIONS searchmesgrafica' => 'searchmesgrafica']],
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/sfvsites','pluralize' => false,'extraPatterns' => ['GET insertar' => 'insertar']]
            ],
        ], 
        'db' => $db,
        'user' => [
            'identityClass' => 'app\api\modules\v1\models\User',
            'enableAutoLogin' => false,
        ], 
    ],
    'modules' => [
        'v1' => [
            'class' => 'app\api\modules\v1\Module',
        ],
    ],
    'params' => $params,
];
 
return $config;