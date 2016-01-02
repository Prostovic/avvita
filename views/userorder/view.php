<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\User;
use app\models\Orderitem;

/* @var $this yii\web\View */
/* @var $model app\models\Userorder */

$bOperator = Yii::$app->user->can(User::GROUP_OPERATOR);
$this->title = 'Заказ ' . $model->ord_id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => [$bOperator ? 'index' : 'list']];
$this->params['breadcrumbs'][] = $this->title;

$attributes = [
//    'ord_id',
//    'ord_us_id',
    'ord_summ',
    [
        'attribute' => 'ord_flag',
        'value' => $model->getStatetitle(),
    ],

//    [
//        'attribute' => 'items',
//        'value' => count($model->goods),
//    ],

    [
        'attribute' => 'items',
        'format' => 'raw',
        'value' => array_reduce(
            $model->goods,
            function($res, $item){
                /** @var Orderitem $item */
                $dop = ($res == '') ? '' : '<br />';
                return $res
                    . $dop
                    . $item->good->gd_title
                    . ' '
                    . $item->ordit_count;
            },
            ''
        ),
    ],

//    'ord_flag',
//    'ord_created',
];

if( $bOperator ) {
    array_splice(
        $attributes,
        0,
        0,
        [[
            'attribute' => 'ord_us_id',
            'value' => $model->user->getUserName(),
        ]]

);
}

?>
<div class="userorder-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->ord_id], ['class' => 'btn btn-success']) ?>
        <?= '' /*Html::a('Delete', ['delete', 'id' => $model->ord_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

</div>
