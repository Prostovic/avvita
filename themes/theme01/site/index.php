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
                    <?= Yii::$app->user->isGuest ? Html::a('Регистрация', ['user/register'], ['class' => 'btn', ]) : '' ?>
                    <!-- a class="btn" href="#">Подробнее</a -->
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="service-wrapper">
                    <i class="fa fa-gift"></i>
                    <h3>Подарки</h3>
                    <p>Мы предоставляем полезные подарки</p>
                    <?= Html::a('Подробнее', Yii::$app->user->can(User::GROUP_CLIENT) ? ['good/index'] : '#goodlist', ['class' => 'btn', ]) ?>
                    <!-- a class="btn" href="#goodlist">Подробнее</a -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if( Yii::$app->user->isGuest ) {
?>
<div class="section section-black">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="calltoaction-wrapper">
                    <h3>Зарегистрируйтесь на нашем портале, накапливайте баллы и получайте подарки!</h3> <?= Html::a('Регистрация', ['user/register'], ['class' => 'btn btn-orange', ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}
?>

<a id="goodlist"></a>
<?= $this->render('//good/userindex', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]);

?>
