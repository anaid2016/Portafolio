<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=18.223.105.203;port=5786;dbname=wm_sge_develop',                    
    'username' => 'postgres',
    'password' => 'aws23Rt54',
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
