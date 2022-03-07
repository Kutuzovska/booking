<?php
declare(strict_types=1);

return [
    'id' => 'app',
    'basePath' => __DIR__,
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@app' => __DIR__ . '/../app/',
    ],
    'components' => [
        'db' => require __DIR__ . '/db.php',
        'user' => require __DIR__ . '/user.php',
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => __DIR__ . '/../migrations',
        ],
    ],
];
