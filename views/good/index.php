<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use app\models\Orderitem;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подарки';
$this->params['breadcrumbs'][] = $this->title;
$columns = [
    'gd_title',
//    'gd_imagepath',
//    'gd_description:ntext',
    'gd_price',
    'gd_number',
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'ordered',
        'value' => function ($model, $key, $index, $column) {
            /** @var Good $model */
//            $nSum = 0;
//            $nCou = 0;
//            foreach($model->goods As $oItem) {
//                /** @var Orderitem $oItem */
//                $nCou++;
//                $nSum += $oItem->ordit_count * $oItem->good->gd_price;
//            }
            return 1; // $model->ordered[0]->orderredcount;
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}' . (Yii::$app->user->can(User::GROUP_CLIENT) ? ' {order}' : ''),
        'buttons' => [
            'order' => function ($url, $model, $key) {
                $options = [
                    'title' => 'Добавить в корзину',
                ];
                return Html::a(
                    '<span class="glyphicon glyphicon-shopping-cart"></span>',
                    ['userorder/append', 'id' => $model->gd_id],
                    $options
                );
            },
        ],
    ],
];
?>
<div class="good-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>

</div>
