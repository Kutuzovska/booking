<?php
declare(strict_types=1);

use app\modules\v1\components\JWT;
use yii\web\Response;

return [
    'id' => 'app',
    'basePath' => __DIR__,
    'controllerNamespace' => 'app\controllers',
    'aliases' => [
        '@app' => __DIR__ . '/../src/',
    ],
    'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ],
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/routes.php',
        ],
        'db' => require __DIR__ . '/db.php',
        'user' => require __DIR__ . '/user.php',
        'request' => [
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'jwt' => [
            'class' => JWT::class,
            'key' => $_ENV['JWT_KEY'],
        ],
        'response' => [
            'format' => Response::FORMAT_JSON,
        ],
    ],
];
