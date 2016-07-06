<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 19.12.2015
 * Time: 15:50
 */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
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
        ['label' => 'О нас', 'url' => ['/site/about']],
//            ['label' => 'Contact', 'url' => ['/site/contact']],
        Yii::$app->user->isGuest ?
        ['label' => 'Вход', 'url' => ['/site/login']] :
        [
            'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ],
        ['label' => 'Регистрация', 'url' => ['/user/register']], // :
    ],
]);
NavBar::end();
