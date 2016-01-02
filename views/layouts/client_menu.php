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
            'label' => 'Подарки',
            'items' => [
                ['label' => 'Все подарки', 'url' => ['good/index']],
                '<li class="dropdown-header">Все подарки в системе</li>',
                '<li class="divider"></li>',
                ['label' => 'Заказанные', 'url' => ['userorder/list', ]],
                '<li class="dropdown-header">Выбранные и заказанные</li>',
            ],
        ],
        [
            'label' => 'Заказы',
            'items' => [
                ['label' => 'Список', 'url' => ['userdata/index']],
                '<li class="dropdown-header">Все Ваши заказы</li>',
                '<li class="divider"></li>',
                ['label' => 'Добавить', 'url' => ['userdata/create', ]],
                '<li class="dropdown-header">Ввод нового заказа</li>',
//                '<li class="divider"></li>',
//                ['label' => 'Заказы', 'url' => ['import/data']],
//                '<li class="dropdown-header">XML файл</li>',
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
