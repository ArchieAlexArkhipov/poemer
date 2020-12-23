<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => 'auth/login',
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
              [
                  'pattern' => 'redactor',
                  'route' => 'redactor/index',
              ],
              [
                  'pattern' => 'redactor/<id:[0-9]+>',
                  'route' => 'redactor/index',
              ],
              [
                  'pattern' => 'profile/<id:[0-9]+>',
                  'route' => 'profile/index',
              ],
              [
                  'pattern' => 'profile/follow/<id:[0-9]+>',
                  'route' => 'profile/follow',
              ],
              [
                  'pattern' => 'poem/poem_<id:[0-9]+>',
                  'route' => 'poem/index',
              ],
              [
                  'pattern' => 'poem/delete/<id:[0-9]+>',
                  'route' => 'poem/delete',
              ],
              [
                  'pattern' => 'poem/delete-comment/<id:[0-9]+>',
                  'route' => 'poem/delete-comment',
              ],
              [
                  'pattern' => 'poems/tag/<id:[0-9]+>',
                  'route' => 'poems/tag',
              ],
              '' => 'site/index',
              '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
