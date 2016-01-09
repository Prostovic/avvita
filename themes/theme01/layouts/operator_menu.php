<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 19.12.2015
 * Time: 15:50
 */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
        'tag' => 'header',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'activateParents' => true,
    'dropDownCaret' => Html::tag('i', '', ['class' => 'fa fa-angle-down']),
    'items' => [
        [
            'label' => 'Главная',
            'url' => ['/'],
            'active' => Yii::$app->defaultRoute == Yii::$app->controller->getRoute(),
        ],
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
            'label' => 'Подарки',
            'items' => [
                ['label' => 'Список подарков', 'url' => ['good/list']],
                '<li class="dropdown-header">Все подарки в системе</li>',
                '<li class="divider"></li>',
                ['label' => 'Пользовательские', 'url' => ['userorder/index', ]],
                '<li class="dropdown-header">Выбранные пользователями</li>',
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
                ['label' => 'Email', 'url' => ['email/index']],
                '<li class="dropdown-header">Файлы email</li>',
//                '<li class="divider"></li>',
            ],
        ],
        [
            'label' => 'Профиль',
            'url' => ['user/profile', ], // 'id' => Yii::$app->user->getId(),
        ],
        [
            'label' => 'Выход', // (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ],
    ],
]);
NavBar::end();
