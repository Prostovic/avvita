<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

use yii\helpers\ArrayHelper;

$sfParamLocal = __DIR__ . DIRECTORY_SEPARATOR . 'params-local.php';

$params = ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    file_exists($sfParamLocal) ? require($sfParamLocal) : []
);

//$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    // 'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', ],
//    'controllerNamespace' => 'app\commands',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>' => '<_c>/index',
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/views/mail',
            'htmlLayout' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'log' => [
            'class' => 'yii\log\Dispatcher',
        ],
    ],

    'params' => $params,
];
