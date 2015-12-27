<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderitemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orderitems';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orderitem-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Orderitem', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ordit_id',
            'ordit_ord_id',
            'ordit_gd_id',
            'ordit_count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
