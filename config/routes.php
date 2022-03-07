<?php
declare(strict_types=1);

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['v1/room'],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['v1/booking' => 'v1/booking'],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['v1/user'],
        'extraPatterns' => [
            'POST login' => 'login',
        ],
    ],

];
