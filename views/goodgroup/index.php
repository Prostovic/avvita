<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GoodgroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goodgroups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goodgroup-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Goodgroup', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'gdgrp_id',
            'gdgrp_gd_id',
            'gdgrp_grp_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
