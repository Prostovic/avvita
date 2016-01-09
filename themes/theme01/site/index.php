<?php

use app\models\User;
use yii\helpers\Html;

$aPerm = [
    User::GROUP_CLIENT,
    User::GROUP_OPERATOR,
    User::GROUP_ADMIN,
    'confirmUser',
];
/* @var $this yii\web\View */

$this->title = Yii::$app->name;


?>
<div class="section section-white">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="service-wrapper">
                    <i class="fa fa-home"></i>
                    <h3>Бонус портал</h3>
                    <p>На нашем пртале Вы можете получать подарки за накопленные баллы по Вашим заказам.</p>
                    <!-- a class="btn" href="#">Подробнее</a -->
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="service-wrapper">
                    <i class="fa fa-briefcase"></i>
                    <h3>Регистрация</h3>
                    <p>Для получения подарков зарегистрируйтесь и получайте баллы за Ваши заказы.</p>
                    <a class="btn" href="#">Подробнее</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="service-wrapper">
                    <i class="fa fa-gift"></i>
                    <h3>Подарки</h3>
                    <p>Мы предоставляем полезные подарки</p>
                    <a class="btn" href="#">Подробнее</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->render('//good/userindex', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]);

?>
