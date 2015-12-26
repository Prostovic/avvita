<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserdataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'ud_id',
    'ud_doc_key',
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'ud_created',
        'value' => function ($model, $key, $index, $column) {
            return date('d.m.Y H:i:s', strtotime($model->ud_created));
        }
    ],
//            'ud_doc_id',
//            'ud_us_id',
//            'ud_created',

];

if( Yii::$app->user->can(User::GROUP_OPERATOR) ) {
    $columns[] = [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'ud_us_id',
        'filter' => ArrayHelper::map(User::getUserList(User::GROUP_CLIENT), 'us_id', 'userName'),
        'value' => function ($model, $key, $index, $column) {
            return Html::encode($model->user->getUserName());
        }
    ];
}

$columns[] = ['class' => 'yii\grid\ActionColumn'];
?>
<div class="userdata-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>

</div>
