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
use app\components\Orderhelper;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

$aActiveData = Orderhelper::getActiveOrderData();
$sActive = '';
$aActiveLink = '#';

if( $aActiveData['goodcount'] > 0 ) {
    $sActive = '<span class="countitems">Корзина: '
        . $aActiveData['goodcount']
        . ' / '
        . $aActiveData['summ']
        . ' '
        . Orderhelper::prepareWord($aActiveData['summ'], '=0{баллов} =1{балл} one{балл} few{балла} many{баллов} other{баллов}')
        . '</span> '
        . ' ';
    $aActiveLink = ['userorder/view', 'id' => $aActiveData['activeorder']];
}

$sActive .= 'Баллы: ' . $aActiveData['available'];

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
            'label' => 'Профиль',
            'url' => ['user/profile', ], // 'id' => Yii::$app->user->getId(),
        ],
        [
            'label' => $sActive,
            'url' => $aActiveLink,
            'encode' => false,
            'active' => false,
        ],
        [
            'label' => 'Выход', //  (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ],
    ],
]);
NavBar::end();
