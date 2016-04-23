<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Userorder;

use app\models\User;
use app\models\Orderitem;

/* @var $this yii\web\View */
/* @var $model app\models\Userorder */

$bOperator = Yii::$app->user->can(User::GROUP_OPERATOR);
$bClient = Yii::$app->user->can(User::GROUP_CLIENT);
$this->title = 'Заказ подарков '
    . (($model->ord_flag != Userorder::ORDER_FLAG_ACTVE) || $bOperator ? $model->ord_id : '');
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
        'value' => $this->render(
            '//orderitem/_backetform',
            [
                'items' => $model->goods,
                'showedit' => false,
            ]
        ),

//        'value' => array_reduce(
//            $model->goods,
//            function($res, $item) {
//                /** @var Orderitem $item */
//                $dop = ($res == '') ? '' : '<br />';
//                return $res
//                    . $dop
//                    . $item->good->gd_title
//                    . ' '
//                    . $item->ordit_count
//                    . ' шт. * '
//                    . $item->good->gd_price
//                    . ' = '
//                    . ($item->ordit_count * $item->good->gd_price);
//            },
//            ''
//        ),
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

    <?= '' /* DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ])*/ ?>

    <?php if( $bOperator ) { ?>
        <p><?php echo Html::encode($model->user->getUserName()); ?></p>
    <?php } ?>

    <?php echo (count($model->goods) == 0) ? '<p>Пока подарков не выбрано</p>' : $this->render(
        '//orderitem/_backetform',
        [
            'order' => $model,
            'items' => $model->goods,
            'showedit' => $bClient && ($model->ord_us_id == Yii::$app->user->getId()) && ($model->ord_flag == Userorder::ORDER_FLAG_ACTVE),
        ]
    ) ?>

    <?php if( $bOperator && (count($model->goods) > 0) ) {
        if( $model->ord_flag == Userorder::ORDER_FLAG_COMPLETED ) {
        ?>
            <p>
                <?= Html::a('Отметить отправленным', ['userorder/send', 'id' => $model->ord_id], ['class' => 'btn btn-success', 'data-method' => 'post',]) ?>
                <?= Html::a('Вернуть клиенту на комплектование', ['userorder/toedit', 'id' => $model->ord_id], ['class' => 'btn btn-success', 'data-method' => 'post',]) ?>
            </p>
        <?php
        }
        else if( $model->ord_flag == Userorder::ORDER_FLAG_SENDED ) {
        ?>
            <p>Заказ отправлен пользователю</p>
        <?php
        }
    ?>
        <p><?php echo Html::encode($model->user->getUserName()); ?></p>
    <?php } ?>


    <p>
        <?= '' // Html::a('Изменить', ['update', 'id' => $model->ord_id], ['class' => 'btn btn-success']) ?>
        <?= '' /*Html::a('Delete', ['delete', 'id' => $model->ord_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

</div>
