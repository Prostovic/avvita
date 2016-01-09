<?php

use yii\helpers\Html;
use app\models\Good;
use app\models\User;
use app\components\Orderhelper;

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

        <?php
        $aImages = $model->images;
//        $s = '';
//        for($i = 0; $i < 30; $i++) {
//            $s .= $i . ' = ' . Orderhelper::prepareWord($i, '=0{баллов} =1{балл} one{балл} few{балла} many{баллов} other{баллов}') . "\n";
//        }
//        Yii::info($s);
        if( count($aImages) > 0 ) {
        ?>
        <div class="single-post-image">
            <img alt="<?= Html::encode($model->gd_title) ?>" src="<?= str_replace(DIRECTORY_SEPARATOR, '/', $aImages[0]->gi_path)  ?>">
        </div>
        <?php
        }
        ?>

        <div class="single-post-info">
            <i class="glyphicon glyphicon-star"></i> <?= $model->gd_price ?> <?= Orderhelper::prepareWord($model->gd_price, '=0{баллов} =1{балл} one{балл} few{балла} many{баллов} other{баллов}') /* Yii::t(
                'app',
                '{n, plural, =0{баллов} =1{балл} one{балл} few{балла} many{баллов} other{баллов}}',
                ['n' => $model->gd_price]
            );*/ ?>
        </div>

        <div class="single-post-content">
            <p><?= Html::encode($model->gd_description) ?></p>
            <?= Yii::$app->user->can(User::GROUP_CLIENT) ?
                Html::a('<span class="glyphicon glyphicon-shopping-cart"></span> Добавить в корзину', ['userorder/append', 'id' => $model->gd_id], $linkOptions) :
                ''
            ?>
        <?php // <a class="btn" href="blog-post.html">Read more</a> ?>
        </div>
    </div>
<!-- /div -->