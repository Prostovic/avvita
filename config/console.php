<?php

use yii\helpers\ArrayHelper;

$sfCommon = __DIR__ . DIRECTORY_SEPARATOR . 'common.php';
$sfCommonLocal = __DIR__ . DIRECTORY_SEPARATOR . 'common-local.php';
$sfConLocal = __DIR__ . DIRECTORY_SEPARATOR . 'console-local.php';

$config = [
    'id' => 'basic-console',
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'logFile' => '@app/runtime/logs/console.log',
                    'maxFileSize' => 300,
                    'maxLogFiles' => 3,
                ],
            ],
        ],
    ],
];

$config = ArrayHelper::merge(
    require($sfCommon),
    file_exists($sfCommonLocal) ? require($sfCommonLocal) : [],
    $config,
    file_exists($sfConLocal) ? require($sfConLocal) : []
);
//print_r($config);
//die();
return $config;
