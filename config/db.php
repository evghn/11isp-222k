<?php

return [
    'class' => 'yii\db\Connection',
    // у вас строка остается вида:    
    // 'dsn' => 'mysql:host=localhost;dbname=название_вашей_бд',
    
    'dsn' => 'mysql:host=MariaDB-11.2;dbname=de_old',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
