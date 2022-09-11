<?php
/*Se eliminan conexiones por seguridad*/
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=xxxxxx;port=xxx;dbname=xxx',                    
    'username' => 'xxx',
    'password' => 'xxx',
    'charset' => 'utf8',
    'schemaMap' => [
      'pgsql'=> [
        'class'=>'yii\db\pgsql\Schema',
        'defaultSchema' => 'public' //specify your schema here
      ]
    ], // PostgreSQL
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
