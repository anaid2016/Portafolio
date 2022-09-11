<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
 
require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
//require(__DIR__ . '/../../config/aliases.php');
 
$config = yii\helpers\ArrayHelper::merge(
    // Advanced app config files
    //require(__DIR__ . '/../../common/config/main.php'),
    //(file_exists(__DIR__ . '/../../common/config/main-local.php') ? require(__DIR__ . '/../../common/config/main-local.php') : [] ),
 
    // Basic app config files
    require(__DIR__ . '/../../config/web.php'),
    (file_exists(__DIR__ . '/../../config/web-local.php') ? require(__DIR__ . '/../../config/web-local.php') : [] ),
 
    // API config files
    require(__DIR__ . '/../config/api.php'),
    (file_exists(__DIR__ . '/../config/api-local.php') ? require(__DIR__ . '/../config/api-local.php') : [] )
);
 
$application = new yii\web\Application($config);
$application->run();