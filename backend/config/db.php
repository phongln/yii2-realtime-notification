<?php
// Production config
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=10.10.10.41;dbname=chromeext_somolocal_db',
    'username' => 'chromeext_somo',
    'password' => '3j4CthXQcsxD',
    'charset' => 'utf8',
];

// Development config
//return [
//    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=localhost;dbname=yii2-realtime',
//    'username' => 'root',
//    'password' => 'root',
//    'charset' => 'utf8',
//];