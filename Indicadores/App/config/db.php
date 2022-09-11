<?php


	/*Se omiten datos de conectividad por seguridad*/

return [
    
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=xxxxx;port=xxxx;dbname=xxxxx',                    
    'username' => 'xxxx',
    'password' => 'xxx',
    'charset' => 'utf8',
    'schemaMap' => [
      'pgsql'=> [
        'class'=>'yii\db\pgsql\Schema',
        'defaultSchema' => 'public' //specify your schema here
      ]
    ], 
];
