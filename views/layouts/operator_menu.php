<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 19.12.2015
 * Time: 15:50
 */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => 'Главная', 'url' => ['/']],
        [
            'label' => 'Заказы',
            'items' => [
                ['label' => 'Список заказов', 'url' => ['docdata/index']],
                '<li class="dropdown-header">Список заказов</li>',
                '<li class="divider"></li>',
                ['label' => 'Пользовательские', 'url' => ['userdata/index', ]],
                '<li class="dropdown-header">Введенные пользователями</li>',
            ],
        ],
        [
            'label' => 'Пользователи',
            'items' => [
                ['label' => 'Список', 'url' => ['user/index']],
                '<li class="dropdown-header">Все пользователи системы</li>',
                '<li class="divider"></li>',
                ['label' => 'Непроверенные', 'url' => ['user/index', 'UserSearch[us_group]' => 'confitmed', ]],
                '<li class="dropdown-header">Непрверенные пользователи</li>',
//                '<li class="divider"></li>',
//                ['label' => 'Заказы', 'url' => ['import/data']],
//                '<li class="dropdown-header">XML файл</li>',
//                '<li class="divider"></li>',
            ],
        ],
        [
            'label' => 'Импорт данных',
            'items' => [
                ['label' => 'Города', 'url' => ['import/city']],
                '<li class="dropdown-header">Excel файл</li>',
                '<li class="divider"></li>',
                ['label' => 'Организации', 'url' => ['import/org']],
                '<li class="dropdown-header">Excel файл</li>',
                '<li class="divider"></li>',
                ['label' => 'Заказы', 'url' => ['import/data']],
                '<li class="dropdown-header">XML файл</li>',
//                '<li class="divider"></li>',
            ],
        ],
        [
            'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ],
    ],
]);
NavBar::end();
