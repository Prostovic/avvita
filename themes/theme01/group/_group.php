<?php

use yii\helpers\Html;
use app\models\Good;
use app\models\User;
use app\components\Orderhelper;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $key string */
/* @var $index integer */
/* @var $widget yii\web\View */
$linkOptions = [
    'title' => 'Товары в группе ' . $model->grp_title,
    'class' =>'btn'
];
?>

<!-- div class="col-sm-6" -->
    <div class="blog-post blog-single-post">
        <div class="single-post-title">
            <h2><?= Html::a(Html::encode($model->grp_title), ['group/goods', 'id' => $model->grp_id]) ?></h2>
        </div>

        <?php
        if( !empty($model->grp_imagepath) ) {
        ?>
        <div class="single-post-image">
            <?= Html::a(
                '<img alt="' . Html::encode($model->grp_title) .'" src="' . $model->grp_imagepath .'">',
                ['group/goods', 'id' => $model->grp_id],
                ['']
            )
        ?>
        </div>
        <?php
        }
        ?>

        <div class="single-post-content">
            <p><?= '' // Html::encode($model->grp_description) ?></p>
            <?= Html::a('<span class="glyphicon glyphicon-share"></span> Подробнее', ['group/goods', 'id' => $model->grp_id], $linkOptions) ?>
        <?php // <a class="btn" href="blog-post.html">Read more</a> ?>
        </div>
    </div>
<!-- /div -->