<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подарки';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="good-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить подарок', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'gd_id',
            'gd_title',
//            'gd_imagepath',
//            'gd_description:ntext',
            'gd_price',
            'gd_number',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'ordered',
//        'value' => function ($model, $key, $index, $column) {
//            /** @var Userorder $model */
//            $nSum = 0;
//            $nCou = 0;
//            foreach($model->goods As $oItem) {
//                /** @var Orderitem $oItem */
//                $nCou++;
//                $nSum += $oItem->ordit_count * $oItem->good->gd_price;
//            }
//            return 'Подарков: ' . $nCou . ' на сумму: ' . $nSum;
//        }
            ],
            // 'gd_active',
            // 'gd_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
