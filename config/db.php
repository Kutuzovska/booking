<?php
declare(strict_types=1);

return [
    'class' => 'yii\db\Connection',
    'dsn' => "pgsql:host=db;dbname=$_ENV[DB_DATABASE]",
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',
];
