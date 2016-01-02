<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\User;
use app\models\Userorder;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

$columns = [];
$columns = array_merge(
    $columns,
    [
    //    ['class' => 'yii\grid\SerialColumn'],

        'ord_id',
    //    'ord_us_id',
    //    'ord_flag',
        [
            'class' => 'yii\grid\DataColumn',
            'attribute' => 'ord_flag',
            'filter' => Userorder::getOrderStates(),
            'value' => function ($model, $key, $index, $column) {
                /** @var Userorder $model */
                return Html::encode($model->getStatetitle());
            }
        ],
        'ord_summ',
    //    'ord_created',

        ['class' => 'yii\grid\ActionColumn'],
    ]
);

//echo str_repeat('-', 30)
//    . '<br />'
//    . nl2br(str_replace(' ', '&nbsp;', var_export($columns, true)))
//    . '<br />';


if( Yii::$app->user->can(User::GROUP_OPERATOR) ) {
    array_splice(
        $columns,
        1,
        0,
        [[
            'class' => 'yii\grid\DataColumn',
            'attribute' => 'ord_us_id',
            'filter' => ArrayHelper::map(User::getUserList(), 'us_id', 'userName'),
            'value' => function ($model, $key, $index, $column) {
                /** @var Userorder $model */
                return Html::encode($model->user->getUserName());
            }
        ]]
    );
}

//echo str_repeat('-', 30)
//    . '<br />'
//    . nl2br(str_replace(' ', '&nbsp;', var_export($columns, true)))
//    . '<br />';

?>
<div class="userorder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- p>
        <?= '' // Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>

</div>
