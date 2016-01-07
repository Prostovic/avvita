<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\User;
use app\models\Userorder;
use app\models\Orderitem;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

$bClient = Yii::$app->user->can(User::GROUP_CLIENT);
$bOperator = Yii::$app->user->can(User::GROUP_OPERATOR);

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
        [
            'class' => 'yii\grid\DataColumn',
            'attribute' => 'ord_summ',
            'value' => function ($model, $key, $index, $column) {
                /** @var Userorder $model */
                $nSum = 0;
                $nCou = 0;
                foreach($model->goods As $oItem) {
                    /** @var Orderitem $oItem */
                    $nCou++;
                    $nSum += $oItem->ordit_count * $oItem->good->gd_price;
                }
                return 'Подарков: ' . $nCou . ' на сумму: ' . $nSum;
            }
        ],
    //    'ord_created',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}' . ($bClient ? ' {delete}' : '') . ($bOperator ? ' {toedit} {send}' : ''),
            'buttons' => [
                'send' => function ($url, $model, $key) {
                    /** @var Userorder $model */
                    $options = [
                        'title' => 'Отметить отправленным',
                        'aria-label' => 'Отметить отправленным',
                        'data-confirm' => 'Отметить данный заказ отправленным?',
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ];
                    return ($model->ord_flag == Userorder::ORDER_FLAG_COMPLETED) ?
                        Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options) :
                        '';
                },
                'toedit' => function ($url, $model, $key) {
                    /** @var Userorder $model */
                    $options = [
                        'title' => 'Вернуть клиенту',
                        'aria-label' => 'Вернуть клиенту',
                        'data-confirm' => 'Вернуть данный заказ клиенту?',
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ];
                    return ($model->ord_flag == Userorder::ORDER_FLAG_COMPLETED) ?
                        Html::a('<span class="glyphicon glyphicon-refresh"></span>', $url, $options) :
                        '';
                },
            ],
        ],
    ]
);

//echo str_repeat('-', 30)
//    . '<br />'
//    . nl2br(str_replace(' ', '&nbsp;', var_export($columns, true)))
//    . '<br />';


if( $bOperator ) {
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
