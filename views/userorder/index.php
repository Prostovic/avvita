<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Userorders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userorder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Userorder', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ord_id',
            'ord_us_id',
            'ord_summ',
            'ord_flag',
            'ord_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
