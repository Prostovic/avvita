<?php

use yii\helpers\Html;
use app\models\Good;

/* @var $this yii\web\View */
/* @var $model app\models\Good */
/* @var $key string */
/* @var $index integer */
/* @var $widget yii\web\View */
$linkOptions = [
    'title' => 'Добавить в корзину: ' . $model->gd_title,
    'class' =>'btn'
];
?>

<!-- div class="col-sm-6" -->
    <div class="blog-post blog-single-post">
        <div class="single-post-title">
            <h2><?= Html::encode($model->gd_title) ?></h2>
        </div>

        <div class="single-post-image">
            <img alt="Post Title" src="img/blog/2.jpg">
        </div>

        <div class="single-post-info">
            <i class="glyphicon glyphicon-star"></i> <?= $model->gd_price ?> <?= Yii::t(
                'app',
                '{n, plural, =0{баллов} =1{балл} one{балл} few{балла} many{баллов} other{баллов}}',
                ['n' => $model->gd_price]
            ); ?>
        </div>

        <div class="single-post-content">
            <p><?= Html::encode($model->gd_description) ?></p>
            <?=  Html::a('<span class="glyphicon glyphicon-shopping-cart"></span> Добавить в корзину', ['userorder/append', 'id' => $model->gd_id], $linkOptions) ?>
        <?php // <a class="btn" href="blog-post.html">Read more</a> ?>
        </div>
    </div>
<!-- /div -->